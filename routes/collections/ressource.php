<?php

// This is an Immediately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('example.php');
return call_user_func(function(){

	$ressourceCollection = new \Phalcon\Mvc\Micro\Collection();

	$ressourceCollection
		->setPrefix('/ressources')
		->setHandler('\PhalconRest\Controllers\RessourceController')
		->setLazy(true);

	// Set Access-Control-Allow headers.
	$ressourceCollection->options('/', 'optionsBase');
	$ressourceCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$ressourceCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$ressourceCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$ressourceCollection->get('/{id:[0-9]+}', 'getOne');
	$ressourceCollection->head('/{id:[0-9]+}', 'getOne');
	$ressourceCollection->post('/', 'post');
	$ressourceCollection->delete('/{id:[0-9]+}', 'delete');
	$ressourceCollection->put('/{id:[0-9]+}', 'put');
        $ressourceCollection->put('/', 'put');
	$ressourceCollection->patch('/{id:[0-9]+}', 'patch');

	return $ressourceCollection;
});