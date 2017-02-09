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

$cache = new Cache;
$annotationReader = new AnnotationReader;

$cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
	$annotationReader,//usar o AnnotationReader
	$cache //usando ArrayCache (cache driver)
);


$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
//carrega a superclasse de mapeamento de metadata somente no driver chain
//registra Gedmo annotations.NOTE: você pode personaliazar
Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
	$driverChain,
	$cachedAnnotationReader
);


//agora nós queremos registrar as entidades da aplicação
//para isso nós precisamos de outro driver da metadados usado para o namespace das entidades
$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
	$cachedAnnotationReader,
	array(__DIR__.DIRECTORY_SEPARATOR.'src')
);

$driverChain->addDriver($annotationDriver,'SiApi');

$config = new Configuration;
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(true);

//registrando driver de metadados
$config->setMetadataDriverImpl($driverChain);

//usar o driver de cache já inicializado
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

AnnotationRegistry::registerFile(__DIR__.DIRECTORY_SEPARATOR.'vendor'. 
        DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'orm' . 
        DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' . 
        DIRECTORY_SEPARATOR . 'ORM' . DIRECTORY_SEPARATOR . 'Mapping' . 
        DIRECTORY_SEPARATOR . 'Driver' . DIRECTORY_SEPARATOR . 'DoctrineAnnotations.php');

// Third, create event manager and hook prefered extension listeners
$evm = new Doctrine\Common\EventManager();

// sluggable
$sluggableListener = new Gedmo\Sluggable\SluggableListener;
// you should set the used annotation reader to listener, to avoid creating new one for mapping drivers
$sluggableListener->setAnnotationReader($cachedAnnotationReader);
$evm->addEventSubscriber($sluggableListener);


//getting the EntityManager
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