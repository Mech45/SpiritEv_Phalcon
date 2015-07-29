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
        $invitationCollection = new \Phalcon\Mvc\Micro\Collection();

	$invitationCollection->setPrefix('/invitations')
        ->setHandler('\PhalconRest\Controllers\InvitationController')
    	->setLazy(true);

	// Set Access-Control-Allow headers.
	$invitationCollection->options('/', 'optionsBase');
	$invitationCollection->options('/{id}', 'optionsOne');

	// First paramter is the route, which with the collection prefix here would be GET /example/
	// Second paramter is the function name of the Controller.
	$invitationCollection->get('/', 'get');
	// This is exactly the same execution as GET, but the Response has no body.
	$invitationCollection->head('/', 'get');

	// $id will be passed as a parameter to the Controller's specified function
	$invitationCollection->get('/{id:[0-9]+}', 'getOne');
	$invitationCollection->head('/{id:[0-9]+}', 'getOne');
	$invitationCollection->post('/', 'post');
	$invitationCollection->delete('/{id:[0-9]+}', 'delete');
	$invitationCollection->put('/', 'createEventInvitations');
	$invitationCollection->patch('/{id:[0-9]+}', 'patch');

	return $invitationCollection;
});
