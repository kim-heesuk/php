<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
// 클라이언트 IP 주소와 현재 날짜 가져오기
if ($_SERVER['DOCUMENT_ROOT']=="/workspace"){
$ip_addresses = getUserIP();
$ip_addresses['public'] ? $ip_address=$ip_addresses['public'];
$ip_addresses['Private'] ? $ip_address=$ip_addresses['Private'];
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


function getUserIP() {
    $ip = '';
    $privateIPs = [
        '10.0.0.0|10.255.255.255',    // Single class A network
        '172.16.0.0|172.31.255.255',  // 16 contiguous class B networks
        '192.168.0.0|192.168.255.255', // 256 contiguous class C networks
        '127.0.0.0|127.255.255.255'   // localhost
    ];

    $ip_keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // Remove leading and trailing spaces
                
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    // Public IP found
                    return ['public' => $ip, 'private' => null];
                }
            }
        }
    }

    // Fallback to REMOTE_ADDR for private IP
    if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) !== false) {
        return ['public' => null, 'private' => $_SERVER['REMOTE_ADDR']];
    }

    return ['public' => null, 'private' => null];
}

?>