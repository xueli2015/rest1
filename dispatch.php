<?php 

	include 'app.php';
    
    // set REQUEST_URI as the default $uri
    $uri = $_SERVER['REQUEST_URI'];
    
    
    if(strpos($uri, '/api') !== false) {	//The URI which was given in order to access this page; for instance, '/index.html'.

	    // grab everything after API
	    $parts = explode('/api', $uri);
	    
	    if(sizeof($parts) > 0){
			$uri = $parts[1];
		}
	}
	
    
	// handle request
	$app = new Tonic\Application();
	$request = new Tonic\Request(
			array(
				'uri' => $uri
			));


	//我没有在PHP文档中找到 HTTP_ORIGIN 的描述
	if (isset($_SERVER['HTTP_ORIGIN'])) {
	    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	    header('Access-Control-Allow-Credentials: true');
	    header('Access-Control-Max-Age: 86400');    // cache for 1 day
	}
	
	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
	    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	
	    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
	    exit(0);
	}


	$resource = $app->getResource($request);
	$response = $resource->exec();

    
	$response->output();

?>