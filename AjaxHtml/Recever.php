<?php
header("Cache-Control: no-cache, must-revalidate");
header("Content-type: application/json; charset=utf-8");
echo json_encode(["message" => "TEST OK"]);

?>