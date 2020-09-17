<?php
// Require the class
require_once __DIR__ . '/vendor/autoload.php';
include 'functions.php';

// Use this namespace
use Steampixel\Route;

//404 if path not found
Route::pathNotFound(function(){
  http_response_code(404);
  echo json_encode(
    array(
      'status' => 404,
      'message' => 'Not Found.'
    )
    );
});

Route::methodNotAllowed(function(){
  http_response_code(405);
  echo json_encode(
    array(
      'status' => 405,
      'message' => 'Method Not Allowed.'
    )
    );
});

Route::add('/', function() {
  http_response_code(404);
  echo json_encode(
    array(
      'status' => 404,
      'message' => 'Not Found.'
    )
  );
}, 'get');

Route::add('/token', function() {
  getToken();
}, 'post');

Route::add('/api/RealEstates', function() {
  getRealEstates();
}, 'get');

Route::add('/api/RealEstates/([0-9]*)', function($id) {
  getRealEstatesById($id);
}, 'get');

Route::add('/api/RealEstates', function() {
  addRealEstates();
}, 'post');

Route::add('/api/Comments/([0-9]*)', function($id) {
  postComment($id);
}, 'get');

// Run the router
Route::run('/');