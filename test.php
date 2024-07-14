<?php
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


// 사용 예시
$st="20240304";
$code="114100";
$num="90";
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
?>

