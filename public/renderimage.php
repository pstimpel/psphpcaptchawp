<?php
/**
* The public-facing functionality of the plugin.
 *
 * @link       https://wp.peters-webcorner.de
 * @since      1.0.0
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/public
 */
/**
 * renders the captcha
 **
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/public
 * @author     Peter Stimpel <pstimpel+wordpress@googlemail.com>
 */

require_once __DIR__ . '/../public/class-psphpcaptchawp-public.php';

class renderimage {

	public function __construct() {
		
		session_start();
		
		$preset = Psphpcaptchawp_Public::getConfig();

		$phrase = $this->getRandomString($preset);
		
		$this->setSession($phrase);

		$this->renderImage($preset, $phrase);
		
	}
	
	
	
	/**
	 * @param $phpcaptchaConfig
	 * @param $captchaChallenge
	 */
	function setSession($captchaChallenge) {
		
		$_SESSION['psphpcaptchawp_challenge'] = $captchaChallenge;

	}
	
	
	
	/**
	 * @param $phpcaptchaConfig
	 *
	 * @return string
	 */
	function getRandomString($phpcaptchaConfig) {
		
		$result = '';
		
		if($phpcaptchaConfig['strictlowercase'] == true) {
			$characters = strtolower($phpcaptchaConfig['charstouse']);
		} else {
			$characters = $phpcaptchaConfig['charstouse'];
		}
		
		for($i=0;$i < $phpcaptchaConfig['stringlength']; $i++) {
			
			$selectedChar = rand(1, strlen($characters));
			
			$result = $result . substr($characters, $selectedChar - 1, 1);
			
		}
		
		
		return $result;
	}
	
	
	
	
	/**
	 * @param $phpcaptchaConfig
	 * @param $captchaChallenge
	 */
	function renderImage($phpcaptchaConfig, $captchaChallenge) {
		
		header("Content-type: image/png");
		
		$spacedText = '';
		for($i=0; $i < strlen($captchaChallenge); $i++) {
			
			$spacedText = $spacedText . substr($captchaChallenge, $i, 1).' ';
			
		}
		$spacedText = substr($spacedText, 0, strlen($spacedText) - 1);
		
		$fontangle = "0";
		$font = dirname(__FILE__).'/../assets/fonts/Lato-Regular.ttf';
		
		$im = imagecreate($phpcaptchaConfig['sizewidth'], $phpcaptchaConfig['sizeheight']);
		
		$crgb = $this->convertRGBToArray($phpcaptchaConfig['bgcolor']);
		$bgcolor = imagecolorallocate($im,
			$crgb['r'],
			$crgb['g'],
			$crgb['b']);
		
		imagefilledrectangle($im, 0, 0,
			$phpcaptchaConfig['sizewidth'], $phpcaptchaConfig['sizeheight'], $bgcolor);
		
		
		$frgb = $this->convertRGBToArray($phpcaptchaConfig['textcolor']);
		$fontcolor = imagecolorallocate($im,
			$frgb['r'],
			$frgb['g'],
			$frgb['b']);
		
		$box = @imageTTFBbox($phpcaptchaConfig['fontsize'], $fontangle, $font, $spacedText);
		
		$textwidth = abs($box[4] - $box[0]);
		
		$textheight = abs($box[5] - $box[1]);
		
		$xcord = ($phpcaptchaConfig['sizewidth'] / 2) - ($textwidth / 2) - 2;
		
		$ycord = ($phpcaptchaConfig['sizeheight'] / 2) + ($textheight / 2);
		
		imagettftext($im, $phpcaptchaConfig['fontsize'], 0, $xcord, $ycord, $fontcolor, $font, $spacedText);
		
		if($phpcaptchaConfig['numberoflines']>0) {
			
			$lrgb = $this->convertRGBToArray($phpcaptchaConfig['linecolor']);
			$linecolor = imagecolorallocate($im,
				$lrgb['r'],
				$lrgb['g'],
				$lrgb['b']);
			
			for($i=1;$i<=$phpcaptchaConfig['numberoflines'];$i++) {
				
				$x1 = rand(0,$phpcaptchaConfig['sizewidth']);
				$y1 = rand(0,$phpcaptchaConfig['sizeheight']);
				
				$x2 = rand(0,$phpcaptchaConfig['sizewidth']);
				$y2 = rand(0,$phpcaptchaConfig['sizeheight']);
				
				for($j=0;$j<$phpcaptchaConfig['thicknessoflines'];$j++) {
					
					imageline($im, $x1, $y1 + $j,
						$x2,
						$y2 + $j,
						$linecolor);
					
					
				}
			}
		}
		
		imagepng($im);
		
		imagedestroy($im);
	}
	
	function convertRGBToArray($rgb) {
		$value = array('r'=>0, 'g'=>0, 'b'=>0);
		if (preg_match("/([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i", $rgb, $crgb)) {
			$value['r'] = hexdec($crgb[1]);
			$value['g'] = hexdec($crgb[2]);
			$value['b'] = hexdec($crgb[3]);
		}
		return $value;
	}
}

$image = new renderimage();