<?php
if ($_POST['station']) {
    $station = $_POST['station'];//77行からのPOSTで送られてきた駅名
    switch ($station) {
        case "高坂":
            $station_code = 0;
            break;
        case "北坂戸":
            $station_code = 1;
            break;
        case "熊谷":
            $station_code = 2;
            break;
        case "鴻巣":
            $station_code = 3;
            break;
        
        default:
            break;
    }
    $url1 = 'https://api.ekispert.jp/v1/json/operationLine/timetable?key=AAHVX4RuL6EMRTeS&stationName=';
    $url = $url1 . $station; //連結させて「stationName=指定した駅名」 のurlにする
    $json = file_get_contents($url);//APIでデータを取得。
    $arr = json_decode($json, true);//なんかよくわからないけど調べた時にあったから残してる。
    $json_count = count($arr["ResultSet"]["TimeTable"]);//指定した駅に何種類線が通っているかを確認。
    $name = $arr['ResultSet']['TimeTable'][0]['Station']['Name'];//指定した駅名。

    $i =-3;
    foreach($arr['ResultSet']['TimeTable'] as $train_data){
        $train_data_sql = "";
        // print_r($train_data);
        //線を当てはめるコード。例：東部東上線森林公園行きを示すコードはxxxx。
        $code = $train_data['code'];
        //行先。池袋行き、森林公園行き、など。
        $direction = $train_data['Line']['Direction'];


        $url2 = $url1.$station."&code=".$code;//行先のコードを入れることで時刻表の詳細を入手。コード入れないと5~23時までの詳細な時刻表が取り出せない。
        $json2 = file_get_contents($url2);//データを取得。
        $arr2 = json_decode($json2, true);//同文
        $line_sql = "";
        foreach($arr2['ResultSet']['TimeTable']['LineKind'] as $train_kind){
            // echo $train_kind['text'].":".$train_kind['code']."<br>";
            if ($count!=0) {
                $line_sql=$line_sql.",";
            }
            $count++;
            $line_sql = $line_sql."(\"".$train_kind['text']."\",".$train_kind['code'].")";
        }
        $destination_sql = "";
        print_r($line_sql);
        echo "<br>";
        $count=0;
        // TODO:とりあえず全部高坂
        foreach($arr2['ResultSet']['TimeTable']['LineDestination'] as $train_kind){
            // echo $train_kind['text'].":".$train_kind['code']."<br>";
            if ($count!=0) {
                $destination_sql=$destination_sql.",";
            }
            $count++;
            $destination_sql = $destination_sql."(\"".$train_kind['text']."\",".$train_kind['code'].")";
        }
        print_r($destination_sql);
        echo "<br>";
        $source_sql = "(\"".$arr2['ResultSet']['TimeTable']['Line']['Source']."\")";
        print_r($source_sql);
        echo "<br>";
        $count=0;
        foreach($arr2['ResultSet']['TimeTable']['HourTable'] as $train_time){
            foreach($train_time['MinuteTable'] as $train_time_Minute){
                if ($count!=0) {
                    $train_data_sql=$train_data_sql.",";
                }
                $count++;
                // echo $train_time['Hour'].":".str_pad($train_time_Minute['Minute'], 2, 0, STR_PAD_LEFT).'種別コード'.$train_time_Minute['Stop']['kindCode'].'方面コード'.$train_time_Minute['Stop']['destinationCode']."<br>";
                $train_data_sql = $train_data_sql."(\"".$train_time['Hour'].":".str_pad($train_time_Minute['Minute'], 2, 0, STR_PAD_LEFT)."\",".$train_time_Minute['Stop']['kindCode'].",".$train_time_Minute['Stop']['destinationCode'].",".$station_code.",".$i.")";
            }
        }
        print_r($train_data_sql);
        echo "<br>";
        $i++;
    }
    }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UFT-8">
    <title>駅情報APIテスト</title>
</head>

<body>
    <BR>
    <h1>駅情報APIテスト</h1>
    <form action="" method="POST">
    <select name="station">
    <option value="高坂" name = "station1">高坂</option> 
    <option value="北坂戸" name = "station2">北坂戸</option>
    <option value="熊谷" name = "station3">熊谷</option>
    <option value="鴻巣" name = "station3">鴻巣</option>
    </select>
    <input type ="submit"value ="送信" />
    </form>
    
</body>

</html>