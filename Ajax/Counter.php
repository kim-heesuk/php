<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
// 클라이언트 IP 주소와 현재 날짜 가져오기
if ($_SERVER['DOCUMENT_ROOT']=="/workspace"){
$ip_address = $_SERVER['REMOTE_ADDR'];
$visit_date = date('Y-m-d');
include "./conn.php";
$sql = "SELECT ip_address,visit_date FROM visit.visits WHERE ip_address = ? AND visit_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $ip_address, $visit_date);
$stmt->execute();
$result = $stmt->get_result();
	if ($result->num_rows == 0) {
		// 방문 기록이 없으면 새로운 방문자로 간주하고 방문 기록을 추가
		$sql = "INSERT INTO visit.visits (ip_address, visit_date) VALUES (?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ss', $ip_address, $visit_date);
		$stmt->execute();
	}
$sql = "SELECT count(*) as count FROM visit.visits WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$counter = $row['count'];
// 연결 종료
$conn->close();
echo json_encode(["count" => $counter]);
}else{
echo json_encode(["count" => 1]);
}




?>