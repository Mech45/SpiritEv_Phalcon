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
        $groupCollection = new \Phalcon\Mvc\Micro\Collection();

	$groupCollection->setPrefix('/group')
        ->setHandler('\PhalconRest\Controllers\GroupController')
    	->setLazy(true);

	// Set Access-Control-Allow headers.
	$groupCollection->options('/', 'optionsBase');
	$groupCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$groupCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$groupCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$groupCollection->get('/{id:[0-9]+}', 'getOne');
	$groupCollection->head('/{id:[0-9]+}', 'getOne');
	$groupCollection->post('/', 'post');
	$groupCollection->delete('/{id:[0-9]+}', 'delete');
	$groupCollection->put('/{id:[0-9]+}', 'put');
	$groupCollection->patch('/{id:[0-9]+}', 'patch');

	return $groupCollection;
});
