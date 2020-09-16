<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';*/

use \Firebase\JWT\JWT;

$headers = apache_request_headers();
$jwt = isset($headers['Authorization']) ? $headers['Authorization'] : null;
$jwt = str_replace("Bearer ", "", $jwt);

function getToken()
{
    include_once 'config/core.php';

    parse_str(file_get_contents("php://input"), $data);
    $data = (object)$data;
    $data->Username = strtolower($data->Username);

    if ($data->Username == "kalle" && $data->Password === "karlsson") {
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => array(
                "id" => 1,
                "user" => $data->Username
            )
        );
        http_response_code(200);

        $jwt = JWT::encode($token, $key);
        echo json_encode(
            array(
                "status" => 200,
                "message" => "Authorized.",
                "user" => $data->Username,
                "exp" => $token["exp"],
                "jwt" => $jwt
            )
        );
    } else {
        http_response_code(401);

        echo json_encode(
            array(
                "status" => 401,
                "message" => "Incorrect email address or password."
            )
        );
    }
}

function validate()
{
    global $jwt; //get JWT from headers
    include_once 'config/core.php';

    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            http_response_code(200);

            echo json_encode(
                array(
                    "status" => 200,
                    "message" => "Access granted.",
                    "iat" => date("Y-m-d\TH:i:sO", $decoded->iat),
                    "exp" => date("Y-m-d\TH:i:sO", $decoded->exp),
                    "data" => $decoded->data
                )
            );
        } catch (Exception $e) {

            http_response_code(401);

            echo json_encode(
                array(
                    "status" => 401,
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                )
            );
        }
    } else {
        http_response_code(401);

        echo json_encode(
            array(
                "status" => 401,
                "message" => "Access denied."
            )
        );
    }
}

function getRealEstates() {
    global $jwt; //get JWT from headers
    include_once 'config/core.php';
    include_once 'estates.php';
    $estates = new RealEstate();

    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            http_response_code(200);

            echo json_encode(
                $estates->get()
            );
        } catch (Exception $e) {

            http_response_code(401);

            echo json_encode(
                array(
                    "status" => 401,
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                )
            );
        }
    } else {
        http_response_code(401);

        echo json_encode(
            array(
                "status" => 401,
                "message" => "Access denied."
            )
        );
    }
}

function getRealEstatesById($id) {
    global $jwt; //get JWT from headers
    include_once 'config/core.php';
    include_once 'estates.php';
    $estates = new RealEstate();

    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            http_response_code(200);

            echo json_encode(
                $estates->getById($id)
            );
        } catch (Exception $e) {

            http_response_code(401);

            echo json_encode(
                array(
                    "status" => 401,
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                )
            );
        }
    } else {
        http_response_code(401);

        echo json_encode(
            array(
                "status" => 401,
                "message" => "Access denied."
            )
        );
    }
}