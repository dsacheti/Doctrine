<?php


namespace SiApi\Controller;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoriasController implements ControllerProviderInterface
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
        $catController = $app['controllers_factory'];

        //listar
        $catController->get('/categorias',function() use ($app){
            $dados = $app['categoriaService']->fetchAll();
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e número de resultados desejados
        */
        $catController->get('/categorias/pagina/{pg}/{numResultados}',function($pg,$numResultados) use($app)
        {
            $dados = $app['categoriaService']->fetchPage($pg,$numResultados);
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e o número de resultados é definido pelo sistema
        */
        $catController->get('/categorias/pagina/{pg}',function($pg) use($app)
        {
            $dados = $app['categoriaService']->fetchPageSimple($pg);
            return $app->json($dados);
        });

        //listar um
        $catController->get('/categorias/{id}',function($id) use ($app){
            $dados = $app['categoriaService']->find($id);
            return $app->json($dados);
        });

        //buscar pelo nome
        $catController->get('/categorias/nome/{nome}',function($nome) use($app){
            $resultado = $app['categoriaService']->buscarNome($nome);
            return $app->json($resultado);
        });

        //buscar se o nome contém
        $catController->get('/categorias/nome_tem/{nm}',function($nm) use($app){
            $resultado = $app['categoriaService']->buscarNomeContem($nm);
            return $app->json($resultado);
        });

        //cadastrar
        $catController->post('/categorias',function(Request $request)use($app){
            $dados['nome'] = $request->get('nome');

            $resultado = $app['categoriaService']->insert($dados);
            return $app->json($resultado);
        });

        //atualizar
        $catController->put('/categorias/{id}',function(Request $request,$id)use ($app){
            $dados['nome'] = $request->get('nome');

            $resultado = $app['categoriaService']->update($id,$dados);
            return $app->json($resultado);
        });

        //apagar
        $catController->delete('/categorias/{id}',function($id) use ($app){
            $resultado = $app['categoriaService']->delete($id);
            return $app->json($resultado);
        });

        return $catController;
    }
}