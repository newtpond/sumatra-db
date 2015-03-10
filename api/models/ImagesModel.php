<?php

class ImagesModel {
    /**
     * List orig. images in spcies folder
     */
    public function listImgs($sp = '') {
        $sp = trim($sp);
        $orig = IMG_ORIG . '/' . $sp . '/';

        if(file_exists($orig)) {
            $sp = str_replace(' ', '_', $sp);
            $orig_list = array_slice(scandir($orig, SCANDIR_SORT_NONE), 2);
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

            $tiles_info = array(
                'tiles_path' => PUBLIC_URL . 'img/taxa/' . $tiles_path,
                'width' => $orig_img[0],
                'height' => $orig_img[1],
            );
            return $tiles_info;
        }
        return false;
    }

    /**
     * Refresh images after adding/removing original images
     */
    public function refreshImgs() {
        $sp_list = array_slice(scandir(IMG_ORIG, SCANDIR_SORT_NONE), 2);
        $pub_sp_list = array_slice(scandir(IMG_PATH, SCANDIR_SORT_NONE), 2);
        $res = false;

        if(!empty($sp_list)) {

            foreach ($sp_list as $sp) {
                $orig_list = array_slice(scandir(IMG_ORIG . $sp, SCANDIR_SORT_NONE), 2);

                $sp_path = IMG_PATH . ucfirst(str_replace(' ', '_', $sp)) . '/';
                if(!file_exists($sp_path)) {
                    mkdir($sp_path);
                }
                $public_list = array_slice(scandir($sp_path, SCANDIR_SORT_NONE), 2);

                $changed_list = array_merge(
                    array_diff($orig_list, $public_list), 
                    array_diff($public_list, $orig_list)
                );

                if(count($changed_list) > 0) {
                    // Create preview images
                    foreach($changed_list as $img) {
                        $arg1 = escapeshellarg($sp);
                        $arg2 = escapeshellarg($img);
                        
                        // Run in background
                        new ImgRefresh($sp, $img);
                        
                        //exec("php libs/ImgRefresh.php $arg1 $arg2 > /dev/null &");
                        return "success";
                    }
                }
            }
            $res = true;
        }
        foreach($pub_sp_list as $sp) {
            if(!file_exists(IMG_ORIG . '/' . str_replace('_', ' ', $sp))) {
                $this->removePublic($sp);
                $res = true;
            }
        }
        return $res;
    }

    private function removePublic($sp) {
        $it = new RecursiveDirectoryIterator(IMG_PATH . $sp,
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
}