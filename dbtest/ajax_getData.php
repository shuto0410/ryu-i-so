<?php
header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。

$data = ["10:00", "11:10", "12:20", "12:30", "12:40", "13:40", "16:40", "16:50"];
// $data = $_POST;
echo json_encode($data, JSON_UNESCAPED_UNICODE);
exit;
