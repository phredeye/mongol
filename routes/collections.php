<?php

$app->get("/:db/:collection", function($db, $collectionName) use ($app, $mongo) {
	
	$data = array();
	
	$limit = (is_null($app->request->get('limit'))) ? 10 : $app->request->get('limit');
	$skip = (is_null($app->request->get('skip'))) ? 10 : $app->request->get('skip');
	
	$query = $app->request->get();
	
    unset($query['limit']);
    unset($query['skip']);

    $cursor = $mongo->selectDB($db)
		->selectCollection($collectionName)
		->find($query)
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