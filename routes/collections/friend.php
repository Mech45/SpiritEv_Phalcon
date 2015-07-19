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
        $friendCollection = new \Phalcon\Mvc\Micro\Collection();

	$friendCollection->setPrefix('/profile')
        ->setHandler('\PhalconRest\Controllers\FriendController')
    	->setLazy(true);

	// Set Access-Control-Allow headers.
	// $friendCollection->options('/', 'optionsBase');
	$friendCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$friendCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$friendCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$friendCollection->get('/{id:[0-9]+}/friends', 'getOne');
	$friendCollection->head('/{id:[0-9]+}/friends', 'getOne');
	$friendCollection->post('/', 'post');
	$friendCollection->delete('/{id:[0-9]+}', 'delete');
	$friendCollection->put('/{id:[0-9]+}', 'put');
	$friendCollection->patch('/{id:[0-9]+}', 'patch');

	return $friendCollection;
});
