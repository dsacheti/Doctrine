<?php

namespace SiApi\Controller;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ProdutosController implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $prodController = $app['controllers_factory'];

        //API
//listar
        $prodController->get('/produtos',function() use ($app){
            $dados = $app['produtoService']->fetchAll();
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e número de resultados desejados
        */
        $prodController->get('/produtos/pagina/{pg}/{numResultados}',function($pg,$numResultados) use($app)
        {
            $dados = $app['produtoService']->fetchPage($pg,$numResultados);
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e o número de resultados é definido pelo sistema
        */
        $prodController->get('/produtos/pagina/{pg}',function($pg) use($app)
        {
            $dados = $app['produtoService']->fetchPageSimple($pg);
            return $app->json($dados);
        });

        //listar um
        $prodController->get('/produtos/{id}',function($id) use ($app){
            $dados = $app['produtoService']->find($id);
            return $app->json($dados);
        });

        //buscar pelo nome
        $prodController->get('/produtos/nome/{nome}',function($nome) use($app){
            $resultado = $app['produtoService']->buscarNome($nome);
            return $app->json($resultado);
        });

        //buscar pela categoria
        $prodController->get('/produtos/categoria/{id}',function($id) use ($app){
            $resultado = $app['produtoService']->buscarPorCategoria($id);
            return $app->json($resultado);
        });

        //buscar se o nome contém
        $prodController->get('/produtos/nome_tem/{nm}',function($nm) use($app){
            $resultado = $app['produtoService']->buscarNomeContem($nm);
            return $app->json($resultado);
        });

        //buscar se a descrição contém
        $prodController->get('/produtos/descricao_tem/{desc}',function($desc) use($app){
            $resultado = $app['produtoService']->buscarEmailContem($desc);
            return $app->json($resultado);
        });

        //buscar por tag
        $prodController->get('/produtos/tag/{tag}',function($tag) use ($app){
            $resultado = $app['produtoService']->buscarPorTag($tag);
            return $app->json($resultado);
        });

        $prodController->post('/produtos',function(Request $request)use($app){
            $dados['nome'] = $request->get('nome');
            $dados['desc'] = $request->get('desc');
            $dados['valor'] = $request->get('valor');
            $dados['categoria'] = $request->get('categoria');
            $dados['tags'] = $request->get('tags');

            $resultado = $app['produtoService']->insert($dados);
            return $app->json($resultado);
        });

        //atualizar
        $prodController->put('/produtos/{id}',function(Request $request,$id)use ($app){
            $dados['nome'] = $request->get('nome');
            $dados['desc'] = $request->get('desc');
            $dados['valor'] = $request->get('valor');
            $dados['categoria'] = $request->get('categoria');
            $dados['tags'] = $request->get('tags');

            $resultado = $app['produtoService']->update($id,$dados);
            return $app->json($resultado);
        });

        //apagar
        $prodController->delete('/produtos/{id}',function($id) use ($app){
            $resultado = $app['produtoService']->delete($id);
            return $app->json($resultado);
        });

        return $prodController;
    }
}