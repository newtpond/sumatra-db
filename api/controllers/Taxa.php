<?php

/**
 * Taxa controller
 * 
 */
class Taxa extends Controller
{
    /**
     * Default classes response - lists accessable classes (data tables)
     */
    public function index()
    {
        //$this->app->flashNow('info', 'Your credit card is expired');
        $model = $this->loadModel('Taxa');
        $result = $model->listFamilies();

        $this->render('classes/index', array(
            'message' => 'List of all accessible families.',
            'count' => $model->rowsCount('classes'),
            'result' => $result
        ));
    }

    /**
     * Lists all accessible species in family $name (records from data table)
     * @param string $name Family name
     */
    public function spList($name = null)
    {
        $model = $this->loadModel('Taxa');
        $result = $model->listItems($name);

        if($result === false) {
            $this->app->notFound();
        }

        $this->render('classes/index', array(
            'message' => "List of species in family \"{$name}\".",
            'count' => $model->rowsCount($name),
            'result' => $result
        ));
    }

    /**
     * Show data available for a single species
     * @param string $name Family name
     * @param string $id Genus and species name (full name string)
     */
    public function spView($name, $id)
    {
        $model = $this->loadModel('Taxa');
        $result = $model->showItem($name, $id);

        if(!$result) {
            $this->app->notFound();
        }

        $this->render('classes/view', array(
            'message' => "Single object of class \"{$name}\" with ObjectId = {$id}.",
            'result' => $result
        ));
    }
}