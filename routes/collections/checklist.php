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
        $checklistCollection = new \Phalcon\Mvc\Micro\Collection();

	$checklistCollection->setPrefix('/checklist')
        ->setHandler('\PhalconRest\Controllers\ChecklistController')
    	->setLazy(true);

	// Set Access-Control-Allow headers.
	$checklistCollection->options('/', 'optionsBase');
	$checklistCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$checklistCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$checklistCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$checklistCollection->get('/{id:[0-9]+}', 'getOne');
	$checklistCollection->head('/{id:[0-9]+}', 'getOne');
	$checklistCollection->post('/', 'post');
	$checklistCollection->delete('/{id:[0-9]+}', 'delete');
	$checklistCollection->put('/{id:[0-9]+}', 'put');
	$checklistCollection->patch('/{id:[0-9]+}', 'patch');

	return $checklistCollection;
});
