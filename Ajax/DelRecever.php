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
   $input = json_decode(file_get_contents("php://input"), true);
    // 데이터 유효성 검사 및 저장 (예시)
	include "./conn.php";
	$tablename=$input['table'];
	
    if (isset($input["table"])) {
         $tablename=$input["table"];
        if ($tablename=="codename"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);
        }else if($tablename=="corrcare"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);

        }else if($tablename=="divinfo"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);

        }else if($tablename=="divinfoyear"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);

        }else if($tablename=="riskcare"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);

        }else if($tablename=="trendline"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);

        }else if($tablename=="trendyear"){
			$result=Revcodename($input,$conn);
			echo json_encode($result);

        }
       
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input"]);
    }
	
}

function Revcodename($data,$conn){
$result=array();
$keys=array_keys($data);
$sql="delete from  etfvari.".$data['table'];
$stmt = $conn->prepare($sql);
try {
	$stmt->execute();
	$result["message"]= "OK";
	$result["sql"]= $sql;
	
} catch (PDOException $e) {
	$result["message"]= $e->getMessage();
	$result["sql"]= $sql;
}

	
return $result;
}

?>