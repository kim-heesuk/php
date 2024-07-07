<?php

if ($_SERVER['DOCUMENT_ROOT']=="/workspace"){
$servername = "mariadb";
}else{
$servername = "localhost";
}
$db_name = "mysql";
$username = "root";
$password = "heedol12!";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    // PDO 객체를 생성하여 MySQL 데이터베이스에 연결
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 오류 모드 설정: 예외를 발생시킵니다.
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // 연결 오류 시 오류 메시지 출력
}


?>


