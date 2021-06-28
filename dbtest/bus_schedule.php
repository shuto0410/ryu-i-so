<?php
ini_set('display_errors',1);

$selected_station = $_POST['select_station'];
$conn = mysqli_connect("127.0.0.1", "ryu-i-so", "rdbus", "RD_bus") or die("Access failed.");

$res = mysqli_query($conn, "SELECT TypeCode FROM AnnualScheduleTable WHERE ScheduleDate=current_date() LIMIT 1");
$row = mysqli_fetch_array($res);
$type_code = $row[0];

$res = mysqli_query($conn, "SELECT BusTime FROM BusScheduleTable WHERE StationID=$selected_station AND TypeCode=$type_code ORDER BY BusTime");

while($row = mysqli_fetch_array($res)){
    $rows[] = $row[0];
}
$rows[] = null;
// 検索機能に使用する可能性ありなので残しておく
// $res = mysqli_query($conn, "SELECT StationID FROM StationTable");
// $stations[] = array();
// while($row = mysqli_fetch_array($res)){
//   $stations[] = $row[0];
// }
//
// for($i = 1; $i < count($stations); $i++){
//   $res = mysqli_query($conn, "SELECT BusTime FROM BusScheduleTable WHERE StationID=$stations[$i] AND TypeCode=0 ORDER BY BusTime");
//   while($row = mysqli_fetch_array($res)){
//     $rows2[] = $row[0];
//   }
//   $rows[$i - 1] = $rows2;
//   $rows2 = NULL;
// }

$jsonres = json_encode($rows, JSON_UNESCAPED_UNICODE);
echo $jsonres;

mysqli_close($conn);
?>
