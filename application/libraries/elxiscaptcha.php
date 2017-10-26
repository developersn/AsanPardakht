<?php 
/**
* CaptchaV2 File
* Generates CAPTCHA Numbers and Chars Image
* @author Albert Demeter <borex8@hotmail.com>
* @version 2.1
* GNU General Public License (Version 2.1, March 7th, 2006)
*
* based on Hadar Porat's Captcha Numbers class v.1.5 <hpman28@gmail.com>
*
* This program is free software; you can redistribute
* it and/or modify it under the terms of the GNU
* General Public License as published by the Free
* Software Foundation; either version 2 of the License,
* or (at your option) any later version.
*
* This program is distributed in the hope that it will
* be useful, but WITHOUT ANY WARRANTY; without even the
* implied warranty of MERCHANTABILITY or FITNESS FOR A
* PARTICULAR PURPOSE. See the GNU General Public License
* for more details.
*/

/**
* CaptchaNumbersV2 Class
* @access public
* @author Albert Demeter <borex8@hotmail.com>
* @version 2.0
* Modified by Ioannis Sannos (datahell@elxis.org) on 16.09.2006
# Modified by Reza-Sh.IR for reza cmspro on 1390-12-11;
*/

class Elxiscaptcha {
	public $length = 6;
	public $font = 'font/Vera.ttf';
	public $size = 13;
	public $angle = 10;
	public $type = 'png';
	public $height = 34;
	public $width = 70;
	public $grid = 7;
	public $string = '';
	public $captchaType = 'digits'; //chars, digits, mixed, capchars
	public $dotsCount = 0;
	public $bgColorRed = 250;
	public $bgColorGreen = 250;
	public $bgColorBlue = 250;
	public $drawGrid = false;
	public $randomGridColor = false;
	public $randomLetterColor = false;	
	
	public $font_size_min = 11;
	public $font_size_max = 15;
	public $font_angle_min = 0;
	public $font_angle_max = 10;


	public function Elxiscaptcha($length = '', $size = '', $type = '', $captchaType = '', $dotsPercent = 2) {

		if ($length!='') { $this->length = $length; }
		if ($size!='') { $this->size = $size; }
		if ($type!='') { $this->type = $type; }
		if ($captchaType!='') { $this->captchaType = $captchaType; }

		$this->width = $this->length * $this->size + $this->grid + $this->grid;
		$this->height = $this->size + (2 * $this->grid);
		
		// dots count equals #% of all points in the image
		$this->dotsCount = round(($this->width * $this->height) * $dotsPercent / 100);
		
		$this->generateString();
	}


	public function display() {
		$this->sendHeader();
		$image = $this->generate();

		switch ($this->type) {
			case 'jpeg': imagejpeg($image); break;
			case 'png': imagepng($image); break;
			case 'gif': imagegif($image); break;
			default: imagepng($image); break;
		}
	}


	protected function ls($__dir="./",$__pattern="*.*") {
		settype($__dir, "string");
		settype($__pattern, "string");
		$__ls = array();
		$__regexp = preg_quote($__pattern,"/");
		$__regexp = preg_replace("/[\\x5C][\x2A]/",".*",$__regexp);
		$__regexp = preg_replace("/[\\x5C][\x3F]/",".", $__regexp);
		if(is_dir($__dir))
		 if(($__dir_h=@opendir($__dir))!==FALSE)
		 {
		  while(($__file=readdir($__dir_h))!==FALSE)
		   if(preg_match("/^".$__regexp."$/",$__file))
			array_push($__ls,$__file);
		  closedir($__dir_h);
		  sort($__ls,SORT_STRING);
		 }
		return $__ls;
	}


	protected function random_font() {
	$fonts_folder = dirname(__FILE__).'/font/';
		$fonts = $this->ls($fonts_folder, "*.ttf");
		$rand = mt_rand(0, sizeof($fonts)-1);
		$this->font = $fonts_folder.$fonts[$rand];
	}


	protected function random_font_size() {
		$this->size = mt_rand($this->font_size_min, $this->font_size_max );
	}


	protected function random_font_angle() {
		$this->angle = mt_rand($this->font_angle_min, $this->font_angle_max );
	}


	protected function generate() {
		$image = imagecreate($this->width, $this->height) or die("Cannot Initialize new GD image stream");
		
		// colors
		$background_color = imagecolorallocate($image, $this->bgColorRed, $this->bgColorGreen, $this->bgColorBlue);
		if (!$this->randomLetterColor) {
  		    $net_color_1 = imagecolorallocate($image, 10, 200, 10);
  		    $net_color_2 = imagecolorallocate($image, 200, 10, 10);
		}
		if (!$this->randomLetterColor) {
  		    //$stringcolor_1 = imagecolorallocate($image, 0, 0, 0);
			//$stringcolor_2 = imagecolorallocate($image, 54, 109, 170);
  		    $stringcolor_2 = imagecolorallocate($image, mt_rand(50,150), mt_rand(110,160), rand(120,150));
			$stringcolor_1 = imagecolorallocate($image, mt_rand(0,10), mt_rand(10,100), mt_rand(5,50));
		}

		if ($this->drawGrid) {
  		    for ($i = $this->grid; $i < $this->height; $i+=$this->grid) { 
    		    if ($this->randomGridColor) {
      		        $net_color_1 = imagecolorallocate($image, mt_rand(1,255), mt_rand(1,250), mt_rand(1,250));
      		        $net_color_2 = imagecolorallocate($image, mt_rand(1,255), mt_rand(1,250), mt_rand(1,250));
    		    }
  		 	    if ($i%2) {
                    imageline($image, 0, $i, $this->width, $i, $net_color_1);
  				} else {
                    imageline($image, 0, $i, $this->width, $i, $net_color_2);
                }
			}
        }

		// make the text
		$str = $this->getString();
		$x = $this->grid;
		for($i = 0, $n = strlen($str); $i < $n; $i++) {
  		    if ($this->randomLetterColor) {
    		    $stringcolor_1 = imagecolorallocate($image, mt_rand(10,255), mt_rand(1,250), mt_rand(1,250));
                $stringcolor_2 = imagecolorallocate($image, mt_rand(1,255), mt_rand(1,250), mt_rand(1,250));
  		    }
			$this->random_font();
			$this->random_font_size();
			$this->random_font_angle();

            if (function_exists('imagettftext')) { //requires TrueType PHP Library
		 	    if ($i%2) {
                    imagettftext($image, $this->size, $this->angle, $x, $this->size + $this->grid - mt_rand(1, 5), $stringcolor_1, $this->font, $str{$i} );
                } else {
                    imagettftext($image, $this->size, $this->angle, $x, $this->size + $this->grid + mt_rand(1, 5), $stringcolor_2, $this->font, $str{$i} );
                }
            } else {
		 	    if ($i%2) {
                    imagechar($image, 5, $x, $this->grid - mt_rand(1, 5), $str{$i}, $stringcolor_1 );
                } else {
                    imagechar($image, 5, $x, $this->grid + mt_rand(1, 5), $str{$i}, $stringcolor_2 );
                }            
            }
			$x = $x + $this->size;
		}
		
		// grid
		if ($this->drawGrid) {
  		    for ($i = $this->grid; $i < $this->width; $i+=$this->grid) { 
    		    if ($this->randomGridColor) {
                    $net_color_1 = imagecolorallocate($image, mt_rand(1,255), mt_rand(1,250), mt_rand(1,250));
      		        $net_color_2 = imagecolorallocate($image, mt_rand(1,255), mt_rand(1,250), mt_rand(1,250));
    		    }
  		 	    if ($i%2) {
                    imageline($image, $i, 0, $i, $this->height, $net_color_1);
  			    } else {
                    imageline($image, $i, 0, $i, $this->height, $net_color_2);
                }
			}
        }

		for ($i = 0; $i < $this->dotsCount; $i++) {
		 	$x = rand(0, $this->width - 1);
			$y = rand(0, $this->height - 1);
			$rgbIndex = imagecolorat($image, $x, $y);
			$rgb = imagecolorsforindex($image, $rgbIndex);
			//print $x . ' x ' . $y . ' : ' . $rgbIndex . '(' . $rgb['red'] . '-' . $rgb['green'] . '-' . $rgb['blue'] . ')<br>'; 

			// if background color create random pixel color
			if ($rgb['red'] == $this->bgColorRed && $rgb['green'] == $this->bgColorGreen && $rgb['blue'] == $this->bgColorBlue) {
			 	$dotColor = imagecolorallocate($image, mt_rand(1,255), mt_rand(1,255), mt_rand(1,255));
			} else {
			 	// not background color then generate a close shade color
				$rgb['red'] = $rgb['red'] + ((mt_rand(1,100) % 2) == 1 ? 1 : -1) * mt_rand(1, 255 - $rgb['red']);
				if ($rgb['red'] < 0 || $rgb['red'] > 255) { $rgb['red'] = mt_rand(1, 255); }

				$rgb['green'] = $rgb['green'] + ((mt_rand(1,100) % 2) == 1 ? 1 : -1) * mt_rand(1, 255 - $rgb['green']);
				if ($rgb['green'] < 0 || $rgb['green'] > 255) { $rgb['green'] = mt_rand(1, 255); }

				$rgb['blue'] = $rgb['blue'] + ((mt_rand(1,100) % 2) == 1 ? 1 : -1) * mt_rand(1, 255 - $rgb['blue']);
				if ($rgb['blue'] < 0 || $rgb['blue'] > 255) { $rgb['blue'] = mt_rand(1, 255); }

			 	$dotColor = imagecolorallocate($image, $rgb['red'], $rgb['green'], $rgb['blue']);
			}
			imagesetpixel($image, $x, $y, $dotColor);
		}
		return $image;
	}


	protected function generateString() {
		$string = $this->create_random_value($this->length, $this->captchaType);
		$this->string = $string;
		return true;
	}


	protected function sendHeader() {
		header('Content-type: image/' . $this->type);
	}


	protected function getString() {
		return $this->string;
	}
	

    /**
    * Encrypt the string, used for session
    * Added by Ioannis Sannos (Elxis team)
    */
    public function getEncString() {
	date_default_timezone_set('Asia/Tehran');
		$enc = $this->string.date('ymd');
    	
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $enc .= $_SERVER['HTTP_USER_AGENT'];
        }
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $enc .= $_SERVER['REMOTE_ADDR'];
        }
        return md5(base64_encode($enc));
    }
	


   

    protected function create_random_value($length, $type = 'capchars') {
        if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits') && ($type != 'capchars')) { return false; }
        $rand_value = '';
        while (strlen($rand_value) < $length) {
            if ($type == 'digits') {
                $char = mt_rand(1,9);
            } else {
                $char = chr(mt_rand(1,255));
            }
            if ($type == 'mixed') {
                if (preg_match('/^[a-z0-9]$/i', $char)) { $rand_value .= $char; }
            } elseif ($type == 'chars') {
                if (preg_match('/^[a-z]$/i', $char)) { $rand_value .= $char; }
            } elseif ($type == 'digits') {
                if (preg_match('/^[0-9]$/', $char)) { $rand_value .= $char; }
            } elseif ($type == 'capchars') {
                if (preg_match('/^[A-Z]$/', $char)) { $rand_value .= $char; }
            }
        }
        return $rand_value;
    }
	
	
	// added by rezaonline.net
	
	function _check_captcha($x,$y)
	{
		date_default_timezone_set('Asia/Tehran');
			$enc = $x.date('ymd');
    	
		if (isset($_SERVER['HTTP_USER_AGENT']))
			$enc .= $_SERVER['HTTP_USER_AGENT'];
        
		if (isset($_SERVER['REMOTE_ADDR'])) 
			$enc .= $_SERVER['REMOTE_ADDR'];
        
		$xfinal= md5(base64_encode($enc));
		
		if($xfinal===$y)
			return true;
		else
			return false;
	}

}

?>