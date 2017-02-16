<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use SiApi\Service\ClienteService;
use SiApi\Entity\Cliente;
use SiApi\Mapper\ClienteMapper;
use Symfony\Component\HttpFoundation\Request;

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

//API
//listar
$app->get('/api/clientes',function() use ($app){
    $dados = $app['clienteService']->fetchAll();
    return $app->json($dados);
});

/*paginação
*o usuário define a página e número de resultados desejados
*/
$app->get('/api/clientes/pagina/{pg}/{numResultados}',function($pg,$numResultados) use($app)
{
    $dados = $app['clienteService']->fetchPage($pg,$numResultados);
    return $app->json($dados);
});

/*paginação
*o usuário define a página e o número de resultados é definido pelo sistema
*/
$app->get('/api/clientes/pagina/{pg}',function($pg) use($app)
{
    $dados = $app['clienteService']->fetchPageSimple($pg);
    return $app->json($dados);
});

//listar um
$app->get('/api/clientes/{id}',function($id) use ($app){
    $dados = $app['clienteService']->find($id);
    return $app->json($dados);
});

/*
 * Buscar:
 * O sistema detecta se é um email ou nome e faz a busca
 */
$app->get('/api/clientes/busca/{param}',function($param) use($app){
    $param = utf8_decode($param);
    $resultado = $app['clienteService']->buscar($param);
    return $app->json($resultado);
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