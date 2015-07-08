<?php

/*
 * Collections nous permettent de définir des groupes de routes qui seront tous utiliser le même contrôleur.
 * Nous pouvons également définir le gestionnaire d'être paresseux chargé. Les collections peuvent partager un préfixe commun.
 * var $ exampleCollection
 */

/*
 * Ceci est une fonction immeidately Appelé en php. La valeur de retour de la
 * fonction anonyme sera retourné à tout fichier "comprend" il.
 * par exemple $ collection = include ('example.php');
 */
return call_user_func(function(){
        $eventCollection = new \Phalcon\Mvc\Micro\Collection();

	$eventCollection->setPrefix('/event')
        ->setHandler('\PhalconRest\Controllers\EventController')
    	->setLazy(true);

	// Set Access-Control-Allow headers.
	$eventCollection->options('/', 'optionsBase');
	$eventCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$eventCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$eventCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$eventCollection->get('/{id:[0-9]+}', 'getOne');
	$eventCollection->head('/{id:[0-9]+}', 'getOne');
	$eventCollection->post('/', 'post');
	$eventCollection->post('/save-first-step', 'saveFirstStep');
	$eventCollection->delete('/{id:[0-9]+}', 'delete');
	$eventCollection->put('/{id:[0-9]+}', 'put');
	$eventCollection->patch('/{id:[0-9]+}', 'patch');

	return $eventCollection;
});
