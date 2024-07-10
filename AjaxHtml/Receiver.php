<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
//include "./conn.php";
//$result=riskinfo($conn);
//print_r($result);



$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // GET 요청 처리
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
    case 'POST':
        // POST 요청 처리
		$input = json_decode(file_get_contents('php://input'), true);
		$request=$input['request'];
		//echo json_encode(["message" => $request]);
        handlePostRequest($request);
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

function handlePostRequest($request) {
	include "./conn.php";
	if ($request=="divinfo"){
	$result=divinfo($conn);
	echo json_encode($result);
	}else if($request=="riskinfo"){
		$result=riskinfo($conn);
	echo json_encode($result);
	
	}
	
}

function riskinfo($conn){
$codename=array();	
$sql="select code,name from etfvari.codename";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
	$codename[$row['code']]=$row['name'];
	}



$sql="select code,ymean,mmean,ymax,ymin,mmax,mmin,ystartmaxup,ystartmaxdown,mstartmaxup ";
$sql .=" mstartmaxup,mstartmaxdown,yconup,ycondown,mconup,mcondown,ymaxc,yminc,mmaxc, mminc from etfvari.riskcare";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rdata=array();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
		if(array_key_exists($row['code'],$codename)){
			$row['code']=$codename[$row['code']];
			$av=array_values($row);
			$rdata[]=$av;
		}
	
	}
return $rdata;
}

function divinfo($conn){
if ($_SERVER['DOCUMENT_ROOT']=="/workspace"){
$sql="select name as 종목명,substr(divsetday,1,4) as 지급기준년,divperstock as 주당분배금 ,divperprice as 시가대비분배율 from etfvari.divinfo order by name asc, divperprice desc ";
}else{
$sql="select 종목명,substr(지급기준일,1,4) as 지급기준년,주당분배금,시가대비분배율 from etfvari.divinfo order by 종목명 asc, 지급기준일 desc ";
}
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$codes=array();
$codesviews=array();
$codesviewsline=array();
foreach ($results as $row) {
        $name=$row['종목명'];
		$year=$row['지급기준년'];
		$div=$row['주당분배금'];
		$rate=$row['시가대비분배율'];
		$codes[$name][$year]['div'][]=$div;
		$codes[$name][$year]['rate'][]=$rate;
	}

	foreach($codes as $codename =>$vals1) {
		$lastyear=0;
		foreach($vals1 as $year => $vals){
		 $codesviews[$codename][$year]['div']=round(array_sum($vals['div']),0);
		 $codesviews[$codename][$year]['rate']=round(array_sum($vals['rate']),2);
		 $codesviews[$codename][$year]['count']=count($vals['div']);
		 if ($year > $lastyear) {$lastyear=$year;}
		}
		$codesviewsline[]=array($codename,$lastyear,$codesviews[$codename][$lastyear]['div'],$codesviews[$codename][$lastyear]['rate'],$codesviews[$codename][$lastyear]['count']);
	}		
$result['line']=$codesviewsline;
$result['graph']=$codesviews;
return $result;
}


?>