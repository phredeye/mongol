<?php

$app->get("/dbs", function() use ($app, $mongo) {
    $dbs = $mongo->listDBs();
    $app->response()->write(json_encode($dbs));
});

$app->get("/:db", function($db) use ($app, $mongo) {
    $db = $mongo->selectDB($db);
    $collections = $db->listCollections();

    $names = array();
    foreach($collections as $c) {
            $names[] = $c->getName();
    }

    $app->response()->write(json_encode(array("collections" => $names)));
});


