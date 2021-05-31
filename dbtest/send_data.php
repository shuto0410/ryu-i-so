<?php
ini_set('display_errors',1);

$selected_station = $_POST['select_station'];
$conn = mysqli_connect("127.0.0.1", "ryu-i-so", "rdbus", "RD_bus") or die("Access failed.");

$res = mysqli_query($conn, "SELECT ScheduleDate, TypeCode FROM AnnualScheduleTable WHERE ScheduleDate=current_date() LIMIT 1");
$row = mysqli_fetch_array($res);
$type_code = $row[1];

$res = mysqli_query($conn, "SELECT TypeCode, ScheduleType FROM ScheduleTypeTable WHERE TypeCode=$type_code LIMIT 1");
$row = mysqli_fetch_array($res);
$schedule_type = $row[1];

$res = mysqli_query($conn, "SELECT StationID, StationName FROM StationTable WHERE StationID=$selected_station LIMIT 1");
$row = mysqli_fetch_array($res);
$station = $row[1];

$res = mysqli_query($conn, "SELECT StationID, BusTime FROM BusScheduleTable WHERE StationID=$selected_station and curtime() < Bustime and TypeCode=$type_code ORDER BY BusTime LIMIT 1");
$row = mysqli_fetch_array($res);
$bus_time = $row[1];

$result = array("TypeCode" => $type_code, "ScheduleType" => $schedule_type, "StationName" => $station, "BusTime" => $bus_time);
$jsonres = json_encode($result, JSON_UNESCAPED_UNICODE);
echo $jsonres;

mysqli_close($conn);
?>
