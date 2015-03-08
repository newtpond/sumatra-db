<?php

class ImagesModel {

    /**
     * List orig. images in spcies folder
     */
    public function listImgs($sp = '', $refresh = false) {
        $sp = trim($sp);
        $orig = IMG_ORIG . '/' . $sp . '/';

        if(file_exists($orig)) {
            $sp = str_replace(' ', '_', $sp);
            $orig_list = array_slice(scandir( $orig, SCANDIR_SORT_NONE), 2);

            if($refresh) {
                $public_list = $this->importImages($sp);

                $sp_path = IMG_PATH . ucfirst($sp) . '/';

                $added_list = array_diff($orig_list, $public_list);
                if(count($added_list) > 0) {
                    
                    // Create preview images
                    foreach($added_list as $img) {
                        set_time_limit(90);
                        $this->image_resize_jpg($orig . $img, $sp_path . $img, 500, 500, true);

                        // Create folder for image tiles if not exist
                        $tiles_path = $sp_path . '.tiles/' . str_replace('.', '_', $img) . '/';
                        if(!file_exists($tiles_path)) {
                            mkdir($tiles_path);
                        }

                        //init
                        $map_tiler = new MapTiler($orig . $img, array(
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
                }
                $removed_list = array_diff($public_list, $orig_list);
                if(count($added_list) > 0) {

                    foreach($removed_list as $img) {
                        set_time_limit(90);
                        $this->removeImages($sp_path, $img);
                    }
                }
                return array(
                        'count' => count($added_list) + count($removed_list),
                        'added' => $added_list,
                        'removed' => $removed_list,
                    );
            }
            return $orig_list;
        }
        return array();
    }

    public function getImageTiles($sp, $img) {
        $sp = trim($sp);
        $orig = IMG_ORIG . '/' . $sp . '/' . $img;

        if(file_exists($orig)) {

            // Orig image dimensions
            $orig_img = getimagesize($orig);

            // Tiles path (public)
            $sp = str_replace(' ', '_', $sp);
            $sp_path = ucfirst($sp) . '/';
            $tiles_path = $sp_path . '.tiles/' . str_replace('.', '_', $img) . '/';

            // Create image tiles if not exist
            if(!file_exists(IMG_PATH . $tiles_path)) {
                mkdir(IMG_PATH . $tiles_path);
                set_time_limit(60);

                //init
                $map_tiler = new MapTiler($orig, array(
                    'tiles_path' => IMG_PATH . $tiles_path,
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

            $tiles_info = array(
                'tiles_path' => PUBLIC_URL . 'img/taxa/' . $tiles_path,
                'width' => $orig_img[0],
                'height' => $orig_img[1],
            );
            return $tiles_info;
        }
        return false;
    }

    public function refreshImgs() {
        $taxa = $this->listImgs();
        $changed = array();

        foreach($taxa as $taxon) {
            $result = $this->listImgs($taxon, true);
            if($result['count'] > 0)
                $changed[$taxon] = $result;
        }
        return $changed;
    }

    private function importImages($sp) {
        $sp_path = IMG_PATH . ucfirst($sp) . '/';

        // Create public image folder if not exist
        if(!file_exists($sp_path)) {
            mkdir($sp_path);
        }
        // Create tiles folder if not exist
        if(!file_exists($sp_path . '.tiles')) {
            mkdir($sp_path . '.tiles');
        }

        // List existing preview images
        $img_list = array_slice(scandir($sp_path, SCANDIR_SORT_NONE), 3);
        return $img_list;
    }

    private function removeImages($path, $img) {
        // Remove preview image
        unlink($path . $img);

        // Remove tiles
        $dir = $path . '.tiles/' . str_replace('.', '_', $img) . '/';
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
     *
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