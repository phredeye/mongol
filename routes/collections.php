<?php

$app->get("/:db/:collection", function($db, $collectionName) use ($app, $mongo) {
	
    $defaults = array(
            "limit" => 10,
            "skip" => 0
    );

    $params = array_merge($defaults, $app->request()->get());

    $data = array('params'=>$params);

    $limit = intval($params['limit']);
    $skip = intval($params['skip']);

    unset($params['limit']);
    unset($params['skip']);

    $db = $mongo->selectDB($db);
    $collection = $db->selectCollection($collectionName);
    $cursor = $collection->find($params)
                    ->skip($skip)
                    ->limit($limit);

    $data[$collectionName] = array();
    foreach($cursor as $doc) {
            $data[$collectionName][] = $doc;
    }

    $app->response()->write(json_encode($data));
	
});


$app->put("/:db/:collection", function($dbName, $collectionName) use ($app, $mongo) {
    
    $db = $mongo->selectDB($dbName);
    $collection = $db->selectCollection($collectionName);
    
    $doc = $app->request()->put();
    $collection->insert($doc);
    $app->response()->write(json_encode($doc));
});

$app->post("/:db/:collection/:id", function($dbName, $collectionName, $id) use ($app, $mongo) {
   
    $db = $mongo->selectDB($dbName);
    $collection = $db->selectCollection($collectionName);

    $doc = $collection->findOne(array("_id" => new MongoId($id)));    
    $doc = array_merge($doc, $app->request()->post());
    
    $collection->save($doc);
    
    $app->response()->write(json_encode($doc));
});

$app->get("/:db/:collection/:id", function($dbName, $collectionName, $id) use ($app, $mongo) {

    $db = $mongo->selectDB($dbName);
    $collection = $db->selectCollection($collectionName);

    $doc = $collection->findOne(array("_id" => new MongoId($id)));

    $app->response()->write(json_encode($doc));
});

$app->delete("/:db/:collection/:id", function($dbName, $collectionName, $id) use($app, $mongo) {

    $db = $mongo->selectDB($dbName);
    $collection = $db->selectCollection($collectionName);

    $collection->remove(array("_id" => new MongoId($id)), array("justOne" => true));
});