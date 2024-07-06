<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // GET 요청 처리
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
    case 'POST':
        // POST 요청 처리
        handlePostRequest();
        break;
    case 'PUT':
        // PUT 요청 처리
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
    case 'DELETE':
        // DELETE 요청 처리
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
    default:
        // 허용되지 않은 메소드
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}


function handlePostRequest() {
    include "./conn.php";
    $status=0;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        $status=0;
    }else{
        $status=1;
    }

    $input = json_decode(file_get_contents("php://input"), true);
    // 데이터 유효성 검사 및 저장 (예시)
    if (isset($input["name"])) {
        $data = ["id" => $status, "name" => $input["name"]];
        echo json_encode(["message" => "Item created", "data" => $data]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input"]);
    }
}

?>