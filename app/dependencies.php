<?php
use Illuminate\Database\Capsule\Manager as Database;
use Respect\Validation\Validator as V;

$container = $app->getContainer();

$capsule = new Database;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();


$container['db'] = function($c) use ($capsule) {
   return $capsule;
};

$container['HomeController'] = function($c) {  
    return new App\Controllers\HomeController($c);
};


$container['validator'] = function()  {
    return new App\Validation\Validator;
};

$container['database'] = function() {
    $conn = new App\Helpers\Database;
    return $conn->instance();
};

V::with('App\\Validation\\Rules\\');