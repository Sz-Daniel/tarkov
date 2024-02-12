<?php

/** Routes Handler (Step-by-Step)
 *  Retrieve the method used on the previous page = Request method received by the index page -> $_SERVER['REQUEST_METHOD']
 *  Which page the user wants to jump to = Requested page from the request -> $_SERVER['REQUEST_URI']
 *  Create the page map as routes (with a fallback for page not found) -> ?? "notFoundHandler"
 *  PHP is able to call a function where the function name is a string, and this is the basis of the procedure -> $handlerFunction()
 *  
 *  How Handler works
 *  We will need a compiler that is built with the actual page from the template with a prebuilt page -> compileTemplate
 *  Compiler collect params like form data, sql data and other state data and give to the prebuilded page 
 *  and it give back the whole page as string
 */

//Get the method
$method = $_SERVER["REQUEST_METHOD"];

//Get the URI -> Path
$parsed = parse_url($_SERVER['REQUEST_URI']);
$path = $parsed['path'];

//Routes Map
$routes = [
    "GET" => [
        '/' => 'homeHandler',
    ],
];

//Page map and Got data checking
$handlerFunction = $routes[$method][$path] ?? "notFoundHandler";
//Double check - As function exists
$safeHandlerFunction = function_exists($handlerFunction) ? $handlerFunction : "notFoundHandler";
//Handler call
$safeHandlerFunction();

function homeHandler(){
    echo render("wrapper.phtml");
};

function render($path, $params=[]){
    ob_start();
    require __DIR__.'/views/'.$path;
    return ob_get_clean();
}

function apiPOSTtest(){

    // Az API URL-je
    $apiUrl = 'https://jsonplaceholder.typicode.com/posts';

    // Az adatok a POST kéréshez
    $data = array(
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 1,
    );

    // Kérés beállításai
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/json; charset=UTF-8',
            'content' => json_encode($data),
        ),
    );

    // Kérés küldése
    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    // JSON válasz dekódolása
    $json = json_decode($response, true);

    echo '<pre>';
    // A válasz kiírása
    var_dump($json);

}

function apiGETTest(){
  
    // Az API URL-je
    $apiUrl = 'https://jsonplaceholder.typicode.com/posts/1';
    
    // HTTP kérés küldése és válasz lekérése
    $response = file_get_contents($apiUrl);
    
    // JSON válasz dekódolása
    $json = json_decode($response, true);
    
    // A válasz kiírása
    echo '<pre>';
    var_dump($json);
    
    }


    function apiTokentest(){

        // Az API URL-je
        $apiUrl = 'https://identity.tarkov-database.com/v1/oauth/token';
    
        // Az adatok a POST kéréshez
        $data = array(
            'client_id' => $_SERVER['CLIENT_ID'],
            'client_secret' => $_SERVER['CLIENT_SECRET'],
            'grant_type' => 'client_credentials',
        );

    
        // Kérés beállításai
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/json; charset=UTF-8',
                'content' => json_encode($data),
            ),
        );
    
        // Kérés küldése
        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);
    
        // JSON válasz dekódolása
        $json = json_decode($response, true);
    
        echo '<pre>';
        // A válasz kiírása
        var_dump($json);
    
    }