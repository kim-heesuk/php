<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
//include "./conn.php";
//$result=corrcare($conn);
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
        handlePostRequest($request,$input);
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


function handlePostRequest($request,$input) {
	include "./conn.php";
	if ($request=="divinfo"){
	$result=divinfo($conn);
	echo json_encode($result);	
	}else if($request=="divinfodetail"){
		$name=$input['name'];
		$result=divinfodetail($conn,$name);
	echo json_encode($result);
	}
	
	else if($request=="riskinfo"){
		$result=riskinfo($conn);
	echo json_encode($result);
	}
	
	else if($request=="trendinfo"){
		$result=trendinfo($conn);
	echo json_encode($result);
	}
	
	else if($request=="hotword"){
		$result=hotword($conn);
	echo json_encode($result);
	}
	else if($request=="corrcare"){
		$result=corrcare($conn);
	echo json_encode($result);
	}
	else if($request=="corrclose"){
		$startday=$input['startday'];
		$code=$input['code'];
		$result=Stock_Close($startday,$code,"90");
	echo json_encode($result);
	}
	
}

function corrcare($conn){
$codename=array();	
$sql="select code,name from etfvari.codename";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
	$codename[$row['code']]=$row['name'];
	}



$sql="select curdate from etfvari.corrcare order by curdate desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$nrow = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql="select code,analday,curdate, date as finddate ,corr from etfvari.corrcare where curdate = :curdate";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':curdate', $nrow[0]['curdate']);

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rdata=array();
foreach ($results as $row){
	$row['name']=$codename[$row['code']];
	if (array_key_exists($row['code'],$rdata)){
		if ($rdata[$row['code']][4] < $row['corr']){
		$rdata[$row['code']]=array_values($row);
		}
	}else{
	$rdata[$row['code']]=array_values($row);
	}
	}
	
return $rdata;
}

function sendGetRequest($startdate,$code,$num) {
    // cURL 세션 초기화
$url="https://apis.data.go.kr/1160100/service/GetSecuritiesProductInfoService/getETFPriceInfo?";
$url.="serviceKey=OAs5IRcjVD8bOJlCLWyg9WgN2AohcrPd4x8bZzPxp9XRituQpMTVzGCSyDSTVYmi19NSYmmrpwfuo1bN5G3uSA%3D%3D&";
$url.="numOfRows=".$num."&pageNo=1&resultType=json&";
$url.="beginBasDt=".$startdate."&likeSrtnCd=".$code;
    $ch = curl_init();
    // 옵션 설정
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);

    // 요청 실행 및 응답 저장
    $response = curl_exec($ch);

    // 에러 처리
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    // cURL 세션 닫기
    curl_close($ch);

    return $response;
}



function Stock_Close($st,$code,$num){
$stackarray=array();
$json_string = sendGetRequest($st,$code,$num);
$data = json_decode($json_string, true);
if ($data['response']['body']['totalCount'] > 0){
$items=$data['response']['body']['items']['item'];
$needkeys=array('basDt','srtnCd', 'itmsNm', 'clpr');

foreach ($items as $item => $value){
  foreach($needkeys as $key => $needkey){
	$stackarray[$needkey][$item]=$value[$needkey];
 }
}
}
  foreach($needkeys as $key => $needkey){
	$stackarray[$needkey][$item]=$value[$needkey];
	krsort($stackarray[$needkey]);
 }

return $stackarray;
}


function hotword($conn){
$sql="select hotword from etfvari.hotword order by vdate desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $results;	
}
function trendinfo($conn){
$codename=array();	
$sql="select code,name from etfvari.codename";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
	$codename[$row['code']]=$row['name'];
	}
	


$sql="select code,week,open1month,open3month,open6month,nowyear,open1year, ";
$sql .=" open2year,open3year,open4year,open5year,openavg,tot,close,open1monthv,";
$sql .="open3monthv,open6monthv,nowyearv,open1yearv,open2yearv,open3yearv,open4yearv,";
$sql .=" open5yearv from etfvari.trendline ";
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

function riskinfo($conn){
$codename=array();	
$sql="select code,name from etfvari.codename";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
	$codename[$row['code']]=$row['name'];
	}
$sql="select code, round((ymaxc/(ymaxc+yminc) *100),2) as yvratio, round((mmaxc/(mmaxc+mminc) *100),2) as mvratio, ymean,mmean,ymax,ymin,mmax,mmin,ystartmaxup,ystartmaxdown, ";
$sql .=" mstartmaxup,mstartmaxdown,yconup,ycondown,mconup,mcondown from etfvari.riskcare";
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
$sql="select 종목명,substr(지급기준일,1,4) as 지급기준년,주당분배금,시가대비분배율 from etfvari.divinfo where 배당구분!='청산분배' && substr(지급기준일,1,4) > '2022' order by 종목명 asc, 지급기준일 desc ";
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

function divinfodetail($conn,$name){
$returnvalue=array();
if ($_SERVER['DOCUMENT_ROOT']=="/workspace"){
$sql="select distinct divsetday as 지급일,round(divperstock,0) as 분배금 ,divperprice as 시가대비, divclass as 구분, round(curprice,0) as 기준가 from etfvari.divinfo where name= ? order by divsetday desc";
$key="name";
}else{
$sql="select distinct 지급기준일 as 지급일,round(주당분배금,0) as 분배금, 시가대비분배율 as 시가대비,배당구분 as 구분, round(결산과표기준가,0) as 기준가 from etfvari.divinfo where 종목명=? order by 지급기준일 desc";
$key="종목명";
}
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $name, PDO::PARAM_STR);  // 첫 번째 위치의 자리표시자에 값을 바인딩
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($results as $row) {
		if (trim($row['시가대비'])=="null" or (int)$row['시가대비'] < 0){
		$row['시가대비'] = round($row['분배금']/$row['기준가'] *100,2);
		}
	$returnvalue[]=array_values($row);
	}
//return $returnvalue;
return $returnvalue;
}

function escapeHTML($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
function processPostData($postData) {
    $escapedData = [];

    // POST 데이터의 각 값을 이스케이프 처리
    foreach ($postData as $key => $value) {
        $escapedData[$key] = escapeHTML($value);
    }

    return $escapedData;
}
?>