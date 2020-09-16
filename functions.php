<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
include_once 'config/core.php';

use \Firebase\JWT\JWT;

$headers = apache_request_headers();
$jwt = isset($headers['Authorization']) ? $headers['Authorization'] : null;
$jwt = str_replace("Bearer ", "", $jwt);

print_r(file_get_contents("php://input"));