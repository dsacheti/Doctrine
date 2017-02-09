<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use SiApi\Service\ClienteService;
use SiApi\Entity\Cliente;
use SiApi\Mapper\ClienteMapper;
use Symfony\Component\HttpFoundation\Request;

$app['clienteService'] = function () use ($em){
    $clienteEntity = new Cliente();
    $clienteMapper = new ClienteMapper($em);

    $clienteService = new ClienteService($clienteEntity,$clienteMapper);
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

//API
//listar
$app->get('/api/clientes',function() use ($app){
    $dados = $app['clienteService']->fetchAll();
    return $app->json($dados);
});

//listar um
$app->get('/api/clientes/{id}',function($id) use ($app){
    $dados = $app['clienteService']->find($id);
    return $app->json($dados);
});

//cadastrar
$app->post('/api/clientes',function(Request $request)use($app){
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $resultado = $app['clienteService']->insert($dados);
    return $app->json($resultado);
});

//atualizar
$app->put('/api/clientes/{id}',function(Request $request,$id)use ($app){
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $resultado = $app['clienteService']->update($id,$dados);
    return $app->json($resultado);
});

//apagar
$app->delete('/api/clientes/{id}',function($id) use ($app){
    $resultado = $app['clienteService']->delete($id);
    return $app->json($resultado);
});

$app->run();