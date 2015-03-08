<?php
/**
 * API Routes
 * Slim route deffinitions (mapping: API request -> controller/action)
 * required inside custom Router class ($this <=> Router instance)
 *
 */


/**
 * Basic API response
 */
$app->get('(/$|/index$|$)', function()
{
    $this->loadController('index', 'index');
});


/************* taxa group **************/

$app->group('/taxa', function() use ($app)
{
    
    
    /**************  GET  ***************/
    // this is a read only version of the api so it only includes GET routes
    
    /**
     * List families
     */
    $app->get('(/$|/index$|$)', function()
    {
        $this->loadController('taxa', 'index');
    });
    
    /**
     * List species in family
     */
    $app->get('/:name(/$|/index$|$)', function($name) use ($app)
    {
        if ($name === 'index') {
            $app->redirect(URL . 'taxa' . '/');
        }
        $this->loadController('taxa', 'spList', $name);
    });
    
    /**
     * Single species
     */
    $app->get('/:name/:id(/$|/index(/|$)|$)', function($name, $sp) use ($app)
    {
        if ($name === 'index' || $sp === 'index') {
            $app->redirect(URL . 'taxa/');
        } elseif ($sp === 'index') {
            $app->redirect(URL . 'taxa/' . $name . '/');
        }
        $this->loadController('taxa', 'spView', $name, $sp);
    });
});
/*** taxa group END ***/


/************* img group **************/

$app->group('/images', function() use ($app)
{
    
    /**************  GET  ***************/
    // this is a read only version of the api sp it only includes GET routes
    
    /**
     * List species with images
     */
    $app->get('(/$|/index$|$)', function()
    {
        $this->loadController('images', 'index');
    });
    
    /**
     * List images for taxon
     */
    $app->get('/:name(/$|/index$|$)', function($name) use ($app)
    {
        if ($name === 'index') {
            $app->redirect(URL . 'images' . '/');
        } elseif ($name === IMG_TOKEN) { // refresh token called instead of taxon
            $this->loadController('images', 'imgRefresh');
        } else {
            $this->loadController('images', 'imgList', $name);
        }
    });
    
    /**
     * Return image
     */
    $app->get('/:name/:img(/$|/index(/|$)|$)', function($name, $img) use ($app)
    {
        if ($name === 'index' || $img === 'index') {
            $app->redirect(URL . 'images/');
        } elseif ($img === 'index') {
            $app->redirect(URL . 'images/' . $name . '/');
        }
        $this->loadController('images', 'imgTiles', $name, $img);
    });
});
/*** img group END ***/


/****************  errors  *****************/

/**
 * 404 - Not Found
 */
$app->notFound(function()
{
    $this->loadController('error', 'notFound');
});

/**
 * Other errors
 */
$app->error(function(\Exception $e)
{
    $this->loadController('error', 'genericError', $e->getMessage(), $e->getCode());
});

/**
 * Error page
 */
$app->get('/error(/$|/index$|$)', function()
{
    $this->loadController('error', 'genericError');
});
