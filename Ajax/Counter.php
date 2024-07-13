<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
// 클라이언트 IP 주소와 현재 날짜 가져오기
if ($_SERVER['DOCUMENT_ROOT']=="/workspace"){
$ip_address = $_SERVER['REMOTE_ADDR'];
$ip_address = "10.10.10.10";
$visit_date = date('Y-m-d');
include "./conn.php";
$sql = "SELECT ip_address,visit_date FROM visit.visits WHERE ip_address = :ip_address AND visit_date = :visit_date";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':ip_address', $ip_address, PDO::PARAM_STR);  // 명명된 자리표시자에 값을 바인딩
$stmt->bindValue(':visit_date', $visit_date, PDO::PARAM_STR);  // 명명된 자리표시자에 값을 바인딩
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC); // 결과를 가져옴
	if (count($result) == 0) {
		// 방문 기록이 없으면 새로운 방문자로 간주하고 방문 기록을 추가
		
		$sql = "INSERT INTO visit.visits (ip_address, visit_date) VALUES (:ip_address, :visit_date)";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':ip_address', $ip_address);
		$stmt->bindValue(':visit_date', $visit_date);
		
		$stmt->execute();
	}
$sql = "SELECT count(*) as count FROM visit.visits WHERE 1 = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$counter = $row['count'];
echo json_encode(["count" => $counter]);
}

else{
echo json_encode(["count" => 1]);
}




?>