<?php
/**
 * Get Stream Data from Icecast2
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/includes
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Highly based on http://techqa.info/programming/question/15803441/php-script-to-extract-artist-&-title-from-shoutcast/icecast-stream
// I mostly just cleaned it up to make it remotely readable
class Icecast_Stream_Data {
	
	public $valid = false;
	public $useragent = 'Winamp 2.81';

	protected $headers = array();
	protected $metadata = array();

	public function __construct( $location ) {
		
		$errno = $errstr = '';
		$t = parse_url( $location );
		$sock = fsockopen( $t['host'], $t['port'], $errno, $errstr, 5 );
		$path = isset( $t['path'] ) ? $t['path'] : '/';
		
		if ( $sock ) {
			
			$request = 'GET '.$path.' HTTP/1.0' . "\r\n" . 
				'Host: ' . $t['host'] . "\r\n" . 
				'Connection: Close' . "\r\n" . 
				'User-Agent: ' . $this->useragent . "\r\n" . 
				'Accept: */*' . "\r\n" . 
				'icy-metadata: 1' . "\r\n".
				'icy-prebuffer: 65536' . "\r\n".
				( isset( $t['user'] ) ? 'Authorization: Basic ' . base64_encode( $t['user'] . ':' . $t['pass'] ) . "\r\n" : '' ) . 
				'X-TipOfTheDay: Winamp "Classic" rulez all of them.' . "\r\n" . "\r\n";
			
			if ( fwrite( $sock, $request ) ) {

				$theaders = $line = '';

				while ( ! feof( $sock ) ) {

					$line = fgets( $sock, 4096 );

					if ( '' == trim( $line ) ) {
						break;
					}

					$theaders .= $line;
				}

				$theaders = explode( "\r\n", $theaders );

				foreach ( $theaders as $header ) {

					$t = explode( ':', $header ); 

					if ( isset( $t[0] ) && 
						trim( $t[0] ) != '' ) {

						$name = preg_replace( '/[^a-z][^a-z0-9]*/i','', strtolower( trim( $t[0] ) ) );

						array_shift( $t );

						$value = trim( implode( ':', $t ) );

						if ( $value != '' ) {

							if ( is_numeric( $value ) ) {
								$this->headers[$name] = (int) $value;
							}
							else {
								$this->headers[$name] = $value;
							}

						}

					}

				}

				if ( ! isset( $this->headers['icymetaint'] ) ) {

					$data = '';
					$metainterval = 512;

					while( ! feof( $sock ) ) {

						$data .= fgetc( $sock );

						if ( strlen( $data ) >= $metainterval ) break;

					}

					$this->print_data( $data );

					$matches = array();
					preg_match_all( '/([\x00-\xff]{2})\x0\x0([a-z]+)=/i', $data, $matches, PREG_OFFSET_CAPTURE );
					preg_match_all( '/([a-z]+)=([a-z0-9\(\)\[\]., ]+)/i', $data, $matches, PREG_SPLIT_NO_EMPTY );
					
					$title = $artist = '';
					
					foreach ( $matches[0] as $nr => $values ) {
						
						$offset = $values[1];
						$length = ord( $values[0]{0}) + 
							( ord( $values[0]{1} ) * 256 ) + 
							( ord( $values[0]{2} ) * 256 * 256 ) + 
							( ord( $values[0]{3} ) * 256 * 256 * 256 );
						
						$info = substr( $data, $offset + 4, $length );
						$seperator = strpos( $info, '=' );
						
						$this->metadata[ substr( $info, 0, $seperator ) ] = substr( $info, $seperator + 1 );
						
						if ( substr( $info, 0, $seperator ) == 'title' ) $title = substr( $info, $seperator + 1 );
						if ( substr( $info, 0, $seperator ) == 'artist') $artist = substr( $info, $seperator + 1 );
						
					}
					
					$this->metadata['streamtitle'] = $artist . ' - ' . $title;
					
				}
				else {
					
					$metainterval = $this->headers['icymetaint'];
					$intervals = 0;
					$metadata = '';
					
					while ( 1 ) {
						
						$data = '';
						while( ! feof( $sock ) ) {
							
							$data .= fgetc( $sock );
							if ( strlen( $data ) >= $metainterval ) break;
							
						}
						
						$len = join( unpack( 'c', fgetc( $sock ) ) ) * 16;
						
						if ( $len > 0 ) {
							$metadata = str_replace( "\0", '', fread( $sock, $len ) );
							break;
						}
						else {
							$intervals++;
							if ( $intervals > 100 ) break;
						}
						
					}
					
					$metarr = explode( ';', $metadata );
					foreach ( $metarr as $meta ) {
						
						$t = explode( '=', $meta );
						
						if ( isset( $t[0] ) && 
							trim( $t[0] ) != '' ) {
							
							$name = preg_replace( '/[^a-z][^a-z0-9]*/i', '', strtolower( trim( $t[0] ) ) );
							
							array_shift( $t );
							$value = trim( implode( '=', $t ) );
							
							if ( substr( $value, 0, 1 ) == '"' || 
								substr( $value, 0, 1 ) == "'" ) {
								$value = substr( $value, 1 );
							}
							
							if ( substr( $value, -1 ) == '"' || 
								substr( $value, -1 ) == "'" ) {
								$value = substr( $value, 0, -1 );
							}
							
							if ( $value != '' ) {
								$this->metadata[$name] = $value;
							}
							
						}
						
					}
					
				}
				
				fclose( $sock );
				
				$this->valid = true;
				
			}
			else {
				echo 'unable to write.';
			}
			
		}
		else {
			echo 'no socket ' . $errno . ' - ' . $errstr . '.';
		}
		
	}

	public function print_data( $data ) {
		
		$data = str_split( $data );
		$c = 0;
		$string = '';
		
		echo "<pre>\n000000 ";
		foreach ( $data as $char ) {
			
			$string .= addcslashes( $char, "\n\r\0\t" );
			$hex = dechex( join( unpack( 'C', $char ) ) );
			
			if ( $c % 4 == 0 ) echo ' ';
			if ( $c % ( 4 * 4 ) == 0 && 
				$c != 0 ) {
				
				foreach ( str_split( $string ) as $s ) {
					
					if ( ord( $s ) < 32 || 
						ord( $s ) > 126 ){
						echo '\\' . ord( $s );
					}
					else {
						echo $s;
					}
					
				}
				
				echo "\n";
				
				$string = '';
				
				echo str_pad( $c, 6, '0', STR_PAD_LEFT ) . '  ';
				
			}
			
			if ( strlen( $hex ) < 1 ) $hex = '00';
			if ( strlen( $hex ) < 2 ) $hex = '0' . $hex;
			
			echo $hex . ' ';
			
			$c++;
			
		}
		
		echo "  $string\n</pre>";
		
	}

	public function get( $name ) {
		
		if ( isset( $this->metadata[$name] ) ) {
			return $this->metadata[$name];
		}
		
		if ( isset( $this->headers[$name] ) ) {
			return $this->headers[$name];
		}
		
		return null;
		
	}
	
}

//$t = new Icecast_Stream_Data( '//ice10.securenetsystems.net:80/WJKNAM' );