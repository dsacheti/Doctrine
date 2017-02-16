<?php
require_once __DIR__.'/vendor/autoload.php';

use SiApi\Entity\Produto;
use SiApi\Mapper\ProdutoMapper;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventManager as EventManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ArrayCache as Cache;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\ClassLoader;

$cache = new Doctrine\Common\Cache\ArrayCache;
$annotationReader = new Doctrine\Common\Annotations\AnnotationReader;

$cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
    $annotationReader, // use reader
    $cache // and a cache driver
);

$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    $cachedAnnotationReader, // our cached annotation reader
    array(__DIR__ . DIRECTORY_SEPARATOR . 'src')
);

$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
$driverChain->addDriver($annotationDriver,'SiApi');

$config = new Doctrine\ORM\Configuration;
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(true); // this can be based on production config.
// register metadata driver
$config->setMetadataDriverImpl($driverChain);
// use our allready initialized cache driver
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

AnnotationRegistry::registerFile(__DIR__. DIRECTORY_SEPARATOR .
    'vendor' . DIRECTORY_SEPARATOR .
    'doctrine' . DIRECTORY_SEPARATOR .
    'orm' . DIRECTORY_SEPARATOR .
    'lib' . DIRECTORY_SEPARATOR .
    'Doctrine' . DIRECTORY_SEPARATOR .
    'ORM' . DIRECTORY_SEPARATOR .
    'Mapping' . DIRECTORY_SEPARATOR .
    'Driver' . DIRECTORY_SEPARATOR . 'DoctrineAnnotations.php');

$evm = new Doctrine\Common\EventManager();
$em = EntityManager::create(
    array(
        'driver'  => 'pdo_mysql',
        'host'    => 'localhost',
        'port'    => '3306',
        'user'    => 'homestead',
        'password'  => 'secret',
        'dbname'  => 'trilhando_doctrine',
    ),
    $config,
    $evm
);



$app = new \Silex\Application();

$app['debug'] = true;//debug mode

$app->register(new Silex\Provider\TwigServiceProvider(),array(
    'twig.path' => __DIR__.'/views/',//pasta de templates do twig
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['produtoService'] = function()use ($app){
    $produto = new Produto();
    $produtoMapper = new ProdutoMapper();
    $banco = $app['persistencia'];
    
    return $pService = new \SiApi\Service\ProdutoService($banco,$produto,$produtoMapper);   
};