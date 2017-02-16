<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 16/02/2017
 * Time: 10:02
 */

namespace SiApi\Controller;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientesController implements ControllerProviderInterface
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
        $cliController = $app['controllers_factory'];

        //API
//listar
        $cliController->get('/clientes',function() use ($app){
            $dados = $app['clienteService']->fetchAll();
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e número de resultados desejados
        */
        $cliController->get('/clientes/pagina/{pg}/{numResultados}',function($pg,$numResultados) use($app)
        {
            $dados = $app['clienteService']->fetchPage($pg,$numResultados);
            return $app->json($dados);
        });

        /*paginação
        *o usuário define a página e o número de resultados é definido pelo sistema
        */
        $cliController->get('/clientes/pagina/{pg}',function($pg) use($app)
        {
            $dados = $app['clienteService']->fetchPageSimple($pg);
            return $app->json($dados);
        });

        //listar um
        $cliController->get('/clientes/{id}',function($id) use ($app){
            $dados = $app['clienteService']->find($id);
            return $app->json($dados);
        });

        //buscar pelo nome
        $cliController->get('/clientes/nome/{nome}',function($nome) use($app){
            $resultado = $app['clienteService']->buscarNome($nome);
            return $app->json($resultado);
        });

        //buscar pelo e mail
        $cliController->get('/clientes/email/{email}',function($email) use($app){
            $resultado = $app['clienteService']->buscarEmail($email);
            return $app->json($resultado);
        });

        //buscar se o nome contém
        $cliController->get('/clientes/nome_tem/{nm}',function($nm) use($app){
            $resultado = $app['clienteService']->buscarNomeContem($nm);
            return $app->json($resultado);
        });

        //buscar se o email contém
        $cliController->get('/clientes/email_tem/{mail}',function($mail) use($app){
            $resultado = $app['clienteService']->buscarEmailContem($mail);
            return $app->json($resultado);
        });

        //cadastrar
        $cliController->post('/clientes',function(Request $request)use($app){
            $dados['nome'] = $request->get('nome');
            $dados['email'] = $request->get('email');

            $resultado = $app['clienteService']->insert($dados);
            return $app->json($resultado);
        });

        //atualizar
        $cliController->put('/clientes/{id}',function(Request $request,$id)use ($app){
            $dados['nome'] = $request->get('nome');
            $dados['email'] = $request->get('email');

            $resultado = $app['clienteService']->update($id,$dados);
            return $app->json($resultado);
        });

        //apagar
        $cliController->delete('/clientes/{id}',function($id) use ($app){
            $resultado = $app['clienteService']->delete($id);
            return $app->json($resultado);
        });

        return $cliController;
    }
}