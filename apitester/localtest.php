<?php
$station = $_POST['station'];
//echo $station;
$url1 = 'https://api.ekispert.jp/v1/json/station/light?key=LE_r3TUQDN7BLvaP&name=';
$url = $url1.$station;
//echo $url;
$json = file_get_contents($url);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
//echo $json;
//$arr = json_decode($json);
//echo $arr->ResultSet->Point->Station->Yomi;
$arr = json_decode($json, true);
$json_count = count($arr["ResultSet"]["Point"]);
//echo $json_count;
if ($arr === NULL) {
    return;
}else if($json_count > 2){ 
 $station_name = $arr['ResultSet']['Point'][0]['Station']['Name'];
 $station_spell = $arr['ResultSet']['Point'][0]['Station']['Yomi'];
 $station_address = $arr['ResultSet']['Point'][0]['Prefecture']['Name'];
}
else{
 $station_name = $arr['ResultSet']['Point']['Station']['Name'];
 $station_spell = $arr['ResultSet']['Point']['Station']['Yomi'];
 $station_address = $arr['ResultSet']['Point']['Prefecture']['Name'];
}
?>

<!DOCTYPE html>
<html lang = “ja”>
    <head>
    <meta charset = “UFT-8”>
        <title>駅情報APIテスト</title>
    </head>
    <body>
     <BR>
    <h1>駅情報APIテスト</h1>
    <p>
    [インプットデータ]
     <form action="APItest.php"method ="POST">
      <label for="station">駅名 :</label>
      <input type="text" name="station" id="station">
      <button type="submit">送信</button>
     </form>
    </p>
     <p>
     [レスポンスデータ]<BR>
    <?php
    print "駅名 :";
    echo $station_name;
    echo "<br />";
    print "読み方 :";
    echo $station_spell;
    echo "<br />";
    print "所在県 :";
    echo $station_address;
    ?>
    </p>
    </body>
</html>