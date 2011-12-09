<?php

require_once("lib/Slim/Slim.php");

//With default settings
$app = new Slim(array(
            'log.enable' => true,
            'log.path' => './logs',
            'log.level' => 4
        ));

$mongo = new Mongo();

$app->get("/", function() use ($app) {
    $app->render("home.phtml");
});

$iterator = new DirectoryIterator(dirname(__FILE__) . "/routes");
foreach ($iterator as $fileInfo) {
    if ($fileInfo->isFile()) {
        $fileName = $fileInfo->getFileName();
        $importFile = sprintf("routes/%s", $fileName);
        require_once($importFile);
    }
}



$app->run();