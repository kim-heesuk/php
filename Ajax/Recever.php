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

        }else if($tablename=="divinfo"){

        }else if($tablename=="divinfoyear"){

        }else if($tablename=="riskcare"){

        }else if($tablename=="trenline"){

        }else if($tablename=="trendyear"){

        }
       
    } else {
        //http_response_code(400);
        //echo json_encode(["message" => "Invalid input"]);
    }
	
}


function Revcodename($data,$conn){
$result=array();
$keys=array_keys($data);
$sql="insert into etfvari.".$data['table']."(";
$colstr="";
$valstr="";
for ($i=0; $i < count($keys)-1; $i++){
$colstr .=$keys[$i].",";
$valstr .=" :".$keys[$i].",";
}
$colstr=$sql. rtrim($colstr,",").") values(";
$valstr=rtrim($valstr,",").")";
$sql=$colstr.$valstr;



$stmt = $conn->prepare($sql);
foreach ($data as $key => $value) {
	if ($key!="table"){
		//echo $key .":". $value ."\n";
		$stmt->bindValue(':' . $key, $value);
	}
}
	try {
		$stmt->execute();
		$result["message"]= "OK";
	} catch (PDOException $e) {
		$result["message"]= "NOK";
	}

	
return $result;
}

?>