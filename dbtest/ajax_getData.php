<?php
ini_set('display_errors',1);
// TODO:北坂戸とかを文字で受け取って、変更
$selected_station = $_POST['select_station'];
if ($_POST['UpOrDown']=='up') {
    $UpOrDown = 1;
}else{
    $UpOrDown = 0;
}
// $UpOrDown = 1;
$conn = mysqli_connect("127.0.0.1", "ryu-i-so", "rdbus", "RD_bus") or die("Access failed.");
$res = mysqli_query($conn,"SELECT TrainTime FROM train_schedule WHERE UpOrDown = $UpOrDown  AND TrainKind = $selected_station ");
while($row = mysqli_fetch_array($res)){
    $rows[] = $row[0];
}
$rows[] = null;
$jsonres = json_encode($rows, JSON_UNESCAPED_UNICODE);
echo $jsonres;
mysqli_close($conn);
?>
