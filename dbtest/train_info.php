<?php
ini_set('display_errors',1);
// TODO:北坂戸とかを文字で受け取って、変更
// DB設計変えないと(どっかのカラムに識別)
// (時間、急行、行先、高坂、上り)
$selected_station = $_POST['select_station'];
if ($_POST['UpOrDown']=='up') {
    $UpOrDown = 1;
}else{
    $UpOrDown = 0;
}
$conn = mysqli_connect("127.0.0.1", "ryu-i-so", "rdbus", "RD_bus") or die("Access failed.");
$res = mysqli_query($conn, "SELECT train_schedule.TrainTime,trainLineKind.name,trainLineDestination.name FROM train_schedule 
LEFT JOIN trainLineKind ON train_schedule.LineKind = trainLineKind.id AND train_schedule.TrainKind = trainLineKind.trainId 
LEFT JOIN trainLineDestination ON train_schedule.LineDestination  = trainLineDestination.id AND train_schedule.TrainKind = trainLineDestination.trainId AND trainLineDestination.UpOrDown = $UpOrDown
WHERE train_schedule.UpOrDown = $UpOrDown AND train_schedule.TrainKind = $selected_station");
while ($row = mysqli_fetch_array($res)) {
    $data[] = $row;
}
$jsonres = json_encode($data, JSON_UNESCAPED_UNICODE);
header('Content-Type: application/json; charset=utf-8');
echo $jsonres;
mysqli_close($conn);

?>