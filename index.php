<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require './vendor/autoload.php';
require './inc/configuration.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
	
	require_once("view/_index.php");
	return $response;
});

$app->get('/videos', function (Request $request, Response $response, $args) {
	
	require_once("view/_videos.php");
	return $response;
});

$app->get('/shop', function (Request $request, Response $response, $args) {
	
	require_once("view/shop.php");
	return $response;
});


$app->get('/produtos', function (Request $request, Response $response, $args) {

	$sql = new Sql();

	$data = $sql->select("SELECT * FROM tb_produtos WHERE preco_promorcional > 0 ORDER BY preco_promorcional DESC limit 3") ;

	echo json_encode($data);

	return $response;

});

$app->run();