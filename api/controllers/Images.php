<?php

/**
 * Taxa controller
 * 
 */
class Images extends Controller
{
    /**
     * Lists of species with images
     */
    public function index()
    {
        $model = $this->loadModel('Images');
        $result = $model->listImgs();

        if(empty($result)) {
            $this->app->notFound();
        }

        $this->render('classes/index', array(
            'message' => "Lists of species with images",
            'count' => count($result),
            'result' => $result
        ));
    }

    /**
     * Lists all accessible images for taxon $sp (records from data table)
     * @param string $sp Species name
     */
    public function imgList($sp)
    {
        $model = $this->loadModel('Images');
        $result = $model->listImgs($sp);

        $sp = ucfirst($sp);

        $this->render('classes/index', array(
            'message' => "List of images for taxon \"{$sp}\".",
            'count' => count($result),
            'result' => $result
        ));
    }

    /**
     * Return preview image for taxon
     * @param string $sp Species name
     * @param string $img Image filename
     */
    public function imgTiles($sp, $img)
    {
        $model = $this->loadModel('Images');
        $result = $model->getImageTiles($sp, $img);

        $this->render('classes/index', array(
            'message' => "Tiles info for \"{$sp}\" and \"{$img}\".",
            'count' => count($result),
            'result' => $result
        ));
    }

    /**
     * Refresh preview images and tiles from originals
     * @param string $sp Species name
     * @param boolean $refresh
     */
    public function imgRefresh()
    {
        $model = $this->loadModel('Images');
        $result = $model->refreshImgs();

        $this->render('classes/index', array(
            'message' => "Updated preview images and tiles.",
            'changes' => $result
        ));
    }
}