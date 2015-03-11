<?php

class ImgRefresh
{
	/**
	 * Img name
	 */
	protected $img;

	/**
	 * Source directory path
	 */
	protected $src_path;

	/**
	 * Public directory path
	 */
	protected $pub_path;

	/**
	 * Tiles directory path
 	 */
	protected $tiles_path;

	public function __construct($sp, $img) {
		$this->img = $img;
		$this->src_path = IMG_ORIG . $sp . '/';

		$sp = str_replace(' ', '_', $sp);
		$this->pub_path = IMG_PATH . ucfirst($sp) . '/';
		$this->tiles_path = $this->pub_path . '.tiles/' . str_replace('.', '_', $img) . '/';

		// Make public directories if needed
        $new_dir = $this->checkDir();

        // add preview image and tiles
        if($new_dir) {
        	$this->addedImg();
        }
        echo $new_dir * 20;
        echo "\nsuccess!\n";
	}

	private function addedImg() {
		set_time_limit(90);
        $this->image_resize_jpg($this->src_path . $this->img, $this->pub_path . $this->img, 500, 500, true);

        //init
        $map_tiler = new MapTiler($this->src_path . $this->img, array(
            'tiles_path' => $this->tiles_path,
            'zoom_min' => 1,
            'zoom_max' => 5,
            'scaling_up' => 5,
        ));
        //execute
        try {
            $map_tiler->process(true);
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
	}

	private function checkDir() {
		// Create public image folder if not exist
        if(!file_exists($this->pub_path)) {
            mkdir($this->pub_path);
        } elseif(!file_exists($this->src_path . $this->img)) {
        	$this->removeImage();
        }
        // Create tiles folder if not exist
        if(!file_exists($this->pub_path . '.tiles')) {
            mkdir($this->pub_path . '.tiles');
        }
        echo $this->tiles_path . "\n";
        // Overwrite img tiles folder if incomplete (if includes some of the zoom level images)
        if(file_exists($this->tiles_path)) {
        	$res = glob($this->tiles_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        	if(!empty($res)) {
        		$this->removeImage();
        		mkdir($this->tiles_path);
        	} elseif(count(scandir($this->tiles_path)) > 2) {
        		return false;
        	}
        } else {
        	mkdir($this->tiles_path);
        }
        return true;
	}

	private function removeImage() {
        // Remove preview image
        if(file_exists($this->pub_path . $this->img))
        	unlink($this->pub_path . $this->img);

        // Remove tiles
        $dir = $this->tiles_path;
        if(count(scandir($dir)) > 2) {
	        $it = new RecursiveDirectoryIterator($dir,
	                        RecursiveDirectoryIterator::SKIP_DOTS);
	        $tiles = new RecursiveIteratorIterator($it,
	                        RecursiveIteratorIterator::CHILD_FIRST);
	        foreach($tiles as $file) {
	            if ($file->isDir()){
	                rmdir($file->getRealPath());
	            } else {
	                unlink($file->getRealPath());
	            }
	        }
    	}
    	rmdir($dir);
    }

	/**
     * func IMAGE_RESIZE
     */
    private function image_resize_jpg($image = false,
                            $filename = false,
                            $thumb_width,
                            $thumb_height,
                            $maximize = false,
                            $quality = 75,
                            $image_object = false)
    {
        if (is_resource($image_object) === true) {
            $source_width = imagesx($image_object);
            $source_height = imagesy($image_object);
            $thumb_source = $image_object; 
        } else {
            list($source_width, $source_height, $source_type) = @getimagesize($image);
            switch($source_type) {
                case 1:
                    $thumb_source = imagecreatefromgif($image);
                    break;
                case 2:
                    $thumb_source = imagecreatefromjpeg($image);
                    break;
                case 3:
                    $thumb_source = imagecreatefrompng($image);
                    break;
                default:
                    return false;
                    break;
            }
        }

        if ($maximize === true) {
     
            $target_width = $thumb_width;
            $target_height = $thumb_height;
     
            if ($thumb_width && ($source_width < $source_height)) {
                $thumb_width = ($thumb_height / $source_height) * $source_width;
            } else {
                $thumb_height = ($thumb_width / $source_width) * $source_height;
            }
     
            if ($thumb_height < $target_height) {
                $multiply_height = $target_height / $thumb_height;
                $thumb_height = $thumb_height * $multiply_height;
                $thumb_width = $thumb_width * $multiply_height;
            }
            if ($thumb_width < $target_width) {
                $multiply_width = $target_width / $thumb_width;
                $thumb_height = $thumb_height * $multiply_width;
                $thumb_width = $thumb_width * $multiply_width;
            }
     
            $thumb_height = ceil($thumb_height);
            $thumb_width = ceil($thumb_width);

        } else if ($source_width > $thumb_width or $source_height > $thumb_height) {
     
            $dimensions = $this->image_resize_dimensions($source_width,$source_height,$thumb_width,$thumb_height);
            $thumb_width = $dimensions['x'];
            $thumb_height = $dimensions['y'];
            $target_width = $dimensions['x'];
            $target_height = $dimensions['y'];
        }
        // Resize Nothing
        else {
            $thumb_width = $source_width;
            $thumb_height = $source_height;
            $target_width = $source_width;
            $target_height = $source_height;
        }
     
        $thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);
     
        //imagecopyresampled($thumb_image, $thumb_source, 0, 0, 0, 0, $thumb_width, $thumb_height, $source_width, $source_height);
        $this->fastimagecopyresampled($thumb_image, $thumb_source, 0, 0, 0, 0, $thumb_width, $thumb_height, $source_width, $source_height);
     
        $target_image = imagecreatetruecolor($target_width,$target_height);

        imagecopy ($target_image, $thumb_image, 0, 0, ($thumb_width - $target_width)/2, ($thumb_height - $target_height)/2, $target_width , $target_height);
     
        if($filename === false) {
            unset($thumb_image);
            return array('file'=>$filename,
                       'width'=>$target_width,
                       'height'=>$target_height,
                       'quality'=>$quality,
                       'type'=>$source_type,
                       'object'=>$target_image,
                       );
        } else {
            imagejpeg($target_image, $filename, $quality);
            unset($target_image, $thumb_image);
            return array('file'=>$filename,
                       'width'=>$target_width,
                       'height'=>$target_height,
                       'quality'=>$quality,
                       'type'=>$source_type,
                       );
        }
    }

    /**
     * func IMAGE_RESIZE_DIMENSIONS
     */
    private function image_resize_dimensions($source_width, $source_height, $thumb_width, $thumb_height)
    {
        $source_ratio = $source_width / $source_height;
        $thumb_ratio = $thumb_width / $thumb_height;
        // Ratio is Taller
        if ($thumb_ratio > $source_ratio) {
            $result_height = $thumb_height;
            $result_width = $thumb_height * $source_ratio;
        }
        // Ratio is Wider
        elseif ($thumb_ratio < $source_ratio) {
            $result_width = $thumb_width;
            $result_height = $thumb_width / $source_ratio;
        }
        // Ratio the Same
        elseif($thumb_ratio == $source_ratio) {
            $result_height = $thumb_height;
            $result_width = $thumb_width;
        }
     
        return array('x'=>$result_width,'y'=>$result_height);
    }
 
    /**
     * func fastimagecopyresampled
     *
     */
    private function fastimagecopyresampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality_level = 3)
    {
        if (empty($src_image) || empty($dst_image)) { return false; }
        if ($quality_level <= 1) {
            $temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);
            imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);
            imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);
            imagedestroy ($temp);
        } elseif ($quality_level < 5 && (($dst_w * $quality_level) < $src_w || ($dst_h * $quality_level) < $src_h)) {
            $tmp_w = $dst_w * $quality_level;
            $tmp_h = $dst_h * $quality_level;
            $temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);
            imagecopyresized ($temp, $src_image, $dst_x * $quality_level, $dst_y * $quality_level, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);
            imagecopyresampled ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);
            imagedestroy ($temp);
        } else {
            imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        }
        return true;
    }
}

// if directly run from command line:
if(isset($argv) && count($argv) > 1) {
	$root_path = dirname(dirname(__DIR__));
	define('IMG_ORIG', $root_path . '/images/');
	define('IMG_PATH', $root_path . '/public/img/taxa/');
	require $root_path . '/api/vendor/autoload.php';

	$result = new ImgRefresh($argv[1], $argv[2]);
}


