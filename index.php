<?php

require 'vendor\autoload.php';
include 'bootsrap.php';

use Chatter\Middleware\Logging as ChatterLogging;
use Chatter\Models\Message;

$app = new \Slim\App();
$app->add(new ChatterLogging());
$app->get('/messages', function($request, $response, $args) {
	try{

	$msg = new Message();
	$messages = $msg->all();

	}
	catch(Exception $e){
		return $response->write($e->getMessage());
	}
	$payload = [];
	foreach($messages as $m) {
		$payload[$m->id] = [
			"body" => $m->body,
			"user_id" => $m->user_id,
			"created_at" => $m->created_at
		];
	}
	return $response->withStatus(200)->withJson($payload);
});

$app->run();