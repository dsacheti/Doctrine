<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use SiApi\Service\ClienteService;
use SiApi\Controller\ClientesController;

$app['clienteService'] = function () use ($em){
    $clienteService = new ClienteService($em);
    return $clienteService;
};
$response = new Response();

$app->get('/',function() use($app){//usando a mágica do silex para returnar uma Responsse
    return $app['twig']->render('home.twig',array());

})->bind('home');


$app->get('/clientes',function() use ($app){
    $dados = $app['clienteService']->fetchAll();

    return $app['twig']->render('clientes.twig',['clientes' => $dados]);
})->bind('listClientes');

$cliController = new ClientesController();
$app->mount('/api',$cliController->connect($app));

$app->run();