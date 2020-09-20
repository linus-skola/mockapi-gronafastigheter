<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($requestMethod === 'OPTIONS') {
    ob_end_flush();
    exit();
}

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
            "Issuer" => $iss,
            "Audience" => $aud,
            "Issued" => $iat,
            "NotBefore" => $nbf,
            "Expires" => $exp,
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
                "username" => $data->Username,
                "expires_in" => $token["exp"],
                "token_type" => "bearer",
                "access_token" => $jwt
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
    $estates = new RealEstate(false);

    if ($jwt || !$jwt) {
        try {
            //$decoded = JWT::decode($jwt, $key, array('HS256'));

            try{
                http_response_code(200);
                echo json_encode(
                    $estates->get()
            );
            } catch (Exception $e){
                echo json_encode(
                    array(
                        "status" => http_response_code(),
                        "error" => $e->getMessage()
                    )
                );
            }
            
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

    if ($jwt || !$jwt) {
        try {
            if($jwt){
                $decoded = JWT::decode($jwt, $key, array('HS256'));
                $estates = new RealEstate(true);
            }
            else {
                $estates = new RealEstate(false);
                $estates->IsAuthorized = false;
            }

            try{
                http_response_code(200);
                echo json_encode(
                    $estates->getById($id)
            );
            } catch (Exception $e){
                echo json_encode(
                    array(
                        "status" => http_response_code(),
                        "error" => $e->getMessage()
                    )
                );
            }

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

function addRealEstates() {
    global $jwt; //get JWT from headers
    include_once 'config/core.php';

    $data = json_decode(file_get_contents("php://input"));

    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            try{
                http_response_code(200);
                echo json_encode(
                    $data
            );
            } catch (Exception $e){
                echo json_encode(
                    array(
                        "status" => http_response_code(),
                        "error" => $e->getMessage()
                    )
                );
            }
            
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

function getComment($id) {
    global $jwt; //get JWT from headers
    include_once 'config/core.php';
    include_once 'estates.php';

    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            $commentCount = rand(1,10);
            $commentsArray = array();

            for($i = 0; $i < $commentCount; $i++){
                $comment = new Comment($id, "En random kommentar från Linus mycket mer bättre API än andras.", "Aimbot123", date("Y-m-dTH:i:s"));
                array_push($commentsArray, $comment);
            }

            try{
                http_response_code(200);
                echo json_encode(
                    $commentsArray
            );
            } catch (Exception $e){
                echo json_encode(
                    array(
                        "status" => http_response_code(),
                        "error" => $e->getMessage()
                    )
                );
            }
            
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

function getCommentByUser($user) {
    global $jwt; //get JWT from headers
    include_once 'config/core.php';
    include_once 'estates.php';

    if ($jwt) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            $commentCount = rand(1,10);
            $commentsArray = array();

            for($i = 0; $i < $commentCount; $i++){
                $realEstateId = rand(1,100);
                $comment = new Comment($realEstateId, "En random kommentar från Linus mycket mer bättre API än andras.", $user, date("Y-m-dTH:i:s"));
                array_push($commentsArray, $comment);
            }

            try{
                http_response_code(200);
                echo json_encode(
                    $commentsArray
            );
            } catch (Exception $e){
                echo json_encode(
                    array(
                        "status" => http_response_code(),
                        "error" => $e->getMessage()
                    )
                );
            }
            
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