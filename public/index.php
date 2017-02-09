<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use SiApi\Service\ClienteService;
use SiApi\Entity\Clientes;
use SiApi\Mapper\ClienteMapper;
use Symfony\Component\HttpFoundation\Request;

$app['clienteService'] = function () use ($em){
    $clienteEntity = new Clientes();
    $clienteMapper = new ClienteMapper($em);

    $clienteService = new ClienteService($clienteEntity,$clienteMapper);
    return $clienteService;
};
$response = new Response();

$app->get('/',function(){//usando a mágica do silex para returnar uma Responsse
    return '<h3>APIS e Silex</h3>
<p>Este projeto faz parte é o exercício do curso APIS e Silex da Code.education.</p>';

})->bind('home');

$app->get('/ola/{nome}',function($nome){
    return "<h3>Olá, {$nome}</h3>";
});

$app->get('/cliente',function()use($app){
    $dados['nome'] = "Nome";
    $dados['email'] = "email";

    $result = $app['clienteService']->insert($dados);

    return $app->json($result);
})->bind('cadcliente');

$app->get('/clientes',function() use ($app){
    $dados = $app['clienteService']->fetchAll();

    return $app['twig']->render('clientes.twig',['clientes' => $dados]);
})->bind('listClientes');

//API

$app->get('/api/clientes',function() use ($app){
    $dados = $app['clienteService']->fetchAll();
    return $app->json($dados);
});

$app->get('/api/clientes/{id}',function($id) use ($app){
    $dados = $app['clienteService']->find($id);
    return $app->json($dados);
});

$app->post('/api/clientes',function(Request $request)use($app){
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $resultado = $app['clienteService']->insert($dados);
    return $app->json($resultado);
});

$app->put('/api/clientes/{id}',function(Request $request,$id)use ($app){
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $resultado = $app['clienteService']->update($id,$dados);
    return $app->json($resultado);
});

$app->delete('/api/clientes/{id}',function($id) use ($app){
    $resultado = $app['clienteService']->delete($id);
    return $app->json($resultado);
});

$app->run();