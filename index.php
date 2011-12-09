<?php
require_once("lib/Slim/Slim.php");

//Bootstrap Slim with default settings
$app = new Slim(array(
    'log.enable' => true,
    'log.path' => './logs',
    'log.level' => 4
));

// Instanciate mongo connection
$mongo = new Mongo();

// Load Route Files
foreach (new DirectoryIterator(dirname(__FILE__) . "/routes") as $fileInfo) {
    if ($fileInfo->isFile()) {
        $fileName = $fileInfo->getFileName();
        $importFile = sprintf("routes/%s", $fileName);
        require_once($importFile);
    }
}

// dispatch routes
$app->run();