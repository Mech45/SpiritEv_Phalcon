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
        $profileCollection = new \Phalcon\Mvc\Micro\Collection();

	$profileCollection->setPrefix('/profile')
        ->setHandler('\PhalconRest\Controllers\ProfileController')
    	->setLazy(true);

	// Set Access-Control-Allow headers.
	$profileCollection->options('/', 'optionsBase');
	$profileCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$profileCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$profileCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$profileCollection->get('/{id:[0-9]+}', 'getOne');
	$profileCollection->head('/{id:[0-9]+}', 'getOne');
	$profileCollection->post('/', 'post');
	$profileCollection->delete('/{id:[0-9]+}', 'delete');
	$profileCollection->put('/{id:[0-9]+}', 'put');
        $profileCollection->post('/{id:[0-9]+}/photo', 'putPhoto');
	$profileCollection->patch('/{id:[0-9]+}', 'patch');

	return $profileCollection;
});
