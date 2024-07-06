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
	
	getAuthenticationHeader();
	
	
    if (isset($input["method"])) {
         $tablename=$input['method'];
        if ($tablename=="codename"){
            $result=Revcodename($data,$conn);

        }else if($tablename=="corrcare"){

        }else if($tablename=="divinfo"){

        }else if($tablename=="divinfoyear"){

        }else if($tablename=="riskcare"){

        }else if($tablename=="trenline"){

        }else if($tablename=="trendyear"){

        }
        
        
        
        
        echo json_encode(["message" => "Item created", "data" => $data]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input"]);
    }
}


function Revcodename($data,$conn){

}
function getAuthenticationHeader() {
### 인증성공은 False 인증실패 True
$result=True;
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
		
        if (trim($_SERVER['HTTP_AUTHORIZATION'])=="ZXRmdHJhZGVybWFuYWdlcjpxbndrZWhsd2s="){
		$result=False;
		}else{
		$result=True;
		}
		
    }else{
	$result=True;
	}

echo json_encode(["message" => $result]);
return $result;
}
?>