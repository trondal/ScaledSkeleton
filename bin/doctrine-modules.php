<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Helper\DialogHelper;
use Zend\Mvc\Application;

ini_set('display_errors', true);
chdir(__DIR__);
$previousDir = '.';

while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());
    if ($previousDir === $dir) {
        throw new \RuntimeException(
        'Unable to locate "config/application.config.php": ' .
        'is DoctrineModule in a subdir of your application skeleton?'
        );
    }
    $previousDir = $dir;
    chdir($dir);
}

if (!(@include_once __DIR__ . '/../vendor/autoload.php') && !(@include_once __DIR__ . '/../../../autoload.php')) {
    throw new \RuntimeException('Error: vendor/autoload.php could not be found. Did you run php composer.phar install?');
}

try {
    $application = Application::init(include 'config/application.config.php');

    if (!isset($_SERVER['argv'][1])) {
        throw new \InvalidArgumentException("Missing first argument 'orm_objectmanagername'!");
    }
    
    $objectManagerName = $_SERVER['argv'][1];
    if (strpos($objectManagerName, 'orm_') !== 0) {
        throw new \InvalidArgumentException("First argument must be the name of the ObjectManager, beginning with 'orm_'!");
    }
    if ($objectManagerName == 'orm_default') {
        throw new \InvalidArgumentException("Illegal to use 'orm_default' as objectmanager!");
    }
    
    $config = $application->getConfig();
    if (!isset($config['doctrine']['entitymanager'][$objectManagerName])) {
        throw new \InvalidArgumentException('ObjectManager ' . $objectManagerName . ' not found in configuration!');
    }
    
    $connectionName = $config['doctrine']['entitymanager'][$objectManagerName]['connection'];
    if ($connectionName == 'orm_default') {
        throw new \InvalidArgumentException("Illegal to use 'orm_default' for the connection!");
    }

    $configurationName = $config['doctrine']['entitymanager'][$objectManagerName]['configuration'];
    if ($configurationName == 'orm_default') {
        throw new \InvalidArgumentException("Illegal to use 'orm_default' for the configuration!");
    }
    
    $em = $application->getServiceManager()->get('doctrine.entitymanager.' . $objectManagerName);

    // Remove the objectmanager argument after usage, it is not registered for the cli commands
    array_splice($_SERVER['argv'], 1, 1);

    $cli = new ConsoleApplication();
    $cli->setName('ScaledSkeleton Command Line Interface');
    $cli->setVersion('Labs Module Manager 0.1@dev');
    $helperSet = $cli->getHelperSet();
    $helperSet->set(new DialogHelper(), 'dialog');
    $helperSet->set(new ConnectionHelper($em->getConnection()), 'db');
    $helperSet->set(new EntityManagerHelper($em), 'em');

    $cli->setHelperSet($helperSet);
    $cli->addCommands(array(
        new QueryCommand(),
        new MetadataCommand,
        new CreateCommand(),
        new DropCommand(),
        new UpdateCommand(),
        new EnsureProductionSettingsCommand(),
        new GenerateEntitiesCommand(),
        new GenerateProxiesCommand(),
        new InfoCommand(),
        new RunDqlCommand(),
        new ValidateSchemaCommand
    ));

    $cli->run();
} catch (\Exception $e) {
    echo 'ERROR' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}