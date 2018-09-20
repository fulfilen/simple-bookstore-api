<?php
// Routes

$app->get('/', 'HomeController:index');

$app->post('/register', '\App\Controllers\Auth\RegisterController:register');

$app->post('/login', '\App\Controllers\Auth\LoginController:login');

$app->get('/books', '\App\Controllers\BookStoreController:all');

$app->get('/book/{id}', '\App\Controllers\BookStoreController:single');



$app->group('/api', function(\Slim\App $app) {
 
    $app->post('/rate/{book_id}/{rating}', '\App\Controllers\RatingController:rateBook');

    $app->post('/book', '\App\Controllers\BookStoreController:store');

    $app->put('/book/{id}','\App\Controllers\BookStoreController:update');

    $app->delete('/book/{id}', '\App\Controllers\BookStoreController:delete');
   
});
