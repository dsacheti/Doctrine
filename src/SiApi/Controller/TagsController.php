<?php

namespace SiApi\Controller;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class TagsController implements ControllerProviderInterface
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
        $tagController = $app['controllers_factory'];

        //API
//listar
        $tagController->get('/tags',function() use ($app){
            $dados = $app['tagService']->fetchAll();
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e número de resultados desejados
        */
        $tagController->get('/tags/pagina/{pg}/{numResultados}',function($pg,$numResultados) use($app)
        {
            $dados = $app['tagService']->fetchPage($pg,$numResultados);
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e o número de resultados é definido pelo sistema
        */
        $tagController->get('/tags/pagina/{pg}',function($pg) use($app)
        {
            $dados = $app['tagService']->fetchPageSimple($pg);
            return $app->json($dados);
        });

        //listar um
        $tagController->get('/tags/{id}',function($id) use ($app){
            $dados = $app['tagService']->find($id);
            return $app->json($dados);
        });

        //buscar pelo nome
        $tagController->get('/tags/nome/{nome}',function($nome) use($app){
            $resultado = $app['tagService']->buscarNome($nome);
            return $app->json($resultado);
        });

        //buscar se o nome contém
        $tagController->get('/tags/nome_tem/{nm}',function($nm) use($app){
            $resultado = $app['tagService']->buscarNomeContem($nm);
            return $app->json($resultado);
        });

        //cadastrar
        $tagController->post('/tags',function(Request $request)use($app){
            $dados['nome'] = $request->get('nome');

            $resultado = $app['tagService']->insert($dados);
            return $app->json($resultado);
        });

        //atualizar
        $tagController->put('/tags/{id}',function(Request $request,$id)use ($app){
            $dados['nome'] = $request->get('nome');

            $resultado = $app['tagService']->update($id,$dados);
            return $app->json($resultado);
        });

        //apagar
        $tagController->delete('/tags/{id}',function($id) use ($app){
            $resultado = $app['tagService']->delete($id);
            return $app->json($resultado);
        });

        return $tagController;
    }
}