<?php 
echo "繋がってはいるよ!!";
?>

<?php

if(isset($_POST['confirm'])){
$confirm = $_POST['confirm'];
  }
$url = "https://api.ekispert.jp/v1/json/station/light?key=LE_r3TUQDN7BLvaP&name=".$confirm;// cURLセッションを初期化
print_r($url);
$ch = curl_init();

// オプションを設定
curl_setopt($ch, CURLOPT_URL, $url); // 取得するURLを指定
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 実行結果を文字列で返す
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // サーバー証明書の検証を行わない

// URLの情報を取得
$response =  curl_exec($ch);
print_r($response);

// 取得結果を表示
echo $response;
$result = json_decode($response, true);
print_r($result);
echo $result;
// セッションを終了
//curl_close($conn);

?>

