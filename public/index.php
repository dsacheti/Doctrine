<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use SiApi\Service\ClienteService;
use SiApi\Service\TagService;
use SiApi\Service\CategoriaService;
use SiApi\Service\ProdutoService;
use SiApi\Controller\ClientesController;
use SiApi\Controller\ProdutosController;
use SiApi\Controller\TagsController;
use SiApi\Controller\CategoriasController;

$app['clienteService'] = function () use ($em){
    $clienteService = new ClienteService($em);
    return $clienteService;
};

$app['produtoService'] = function() use ($em) {
    $produtoService = new produtoService($em);
    return $produtoService;
};

$app['tagService'] = function() use ($em) {
    $tagService = new TagService($em);
    return $tagService;
};

$app['categoriaService'] = function() use ($em) {
    $categoriaService = new CategoriaService($em);
    return $categoriaService;
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

$produtosController = new ProdutosController();
$app->mount('/api',$produtosController->connect($app));

$tagController = new TagsController();
$app->mount('/api',$tagController->connect($app));

$categoriasController = new CategoriasController();
$app->mount('/api',$categoriasController->connect($app));


$app->run();