<?php
  ini_set('display_errors',1);
  $json = file_get_contents('php://input');
  $to_via_statoin = json_decode($json);
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($to_via_statoin);
?>