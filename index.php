<?php
// Require the class
include 'src/Steampixel/Route.php';
include '../../api_includes/functions.php';

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

Route::add('/token', function() {

}, 'get');

// Run the router
Route::run('/');