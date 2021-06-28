<?php
if ($_POST['station']) {
    $station = $_POST['station'];//77行からのPOSTで送られてきた駅名
    //echo $station;
    $url1 = 'https://api.ekispert.jp/v1/json/operationLine/timetable?key=AAHVX4RuL6EMRTeS&stationName=';
    $url = $url1 . $station; //連結させて「stationName=指定した駅名」 のurlにする
    //echo $url;
    $json = file_get_contents($url);//APIでデータを取得。
    // $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    //echo $json;
    //$arr = json_decode($json);
    //echo $arr->ResultSet->Point->Station->Yomi;
    $arr = json_decode($json, true);//なんかよくわからないけど調べた時にあったから残してる。
    $json_count = count($arr["ResultSet"]["TimeTable"]);//指定した駅に何種類線が通っているかを確認。
    //echo $json_count;
    $name = $arr['ResultSet']['TimeTable'][0]['Station']['Name'];//指定した駅名。

    for($i = 0;$i < $json_count; $i++){
        $code[$i] = $arr['ResultSet']['TimeTable'][$i]['code'];//線を当てはめるコード。例：東部東上線森林公園行きを示すコードはxxxx。
        $route[$i] = $arr['ResultSet']['TimeTable'][$i]['Line']['Name'];//線の名前。東部東上線など。
        $destination[$i] = $arr['ResultSet']['TimeTable'][$i]['Line']['Direction'];//行先。池袋行き、森林公園行き、など。
        //本来1個しかデータがない場合は[$i]そのものを消さなければいけないけど絶対1本以上あるため分岐なし。
       $url2 = $url1.$station."&code=".$code[$i];//行先のコードを入れることで時刻表の詳細を入手。コード入れないと5~23時までの詳細な時刻表が取り出せない。
       //echo $url;
       $json2 = file_get_contents($url2);//データを取得。
       //echo $json2;
       $arr2 = json_decode($json2, true);//同文

       $json_count2 =count($arr2["ResultSet"]["TimeTable"]["HourTable"]);//Hourtableがいくつあるか数える。
       //echo $json_count2;
       for($k=0;$k< $json_count2;$k++){
           $hour[$i][$k] = $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["Hour"];//count2の数だけHourの中身を格納する。5~23までピッタリ格納。
            $json_count3 = count($arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"]);//echo "&nbsp;";//HourTable内のMinuteがいくつあるかカウント。1時間に何本電車が来るかわかる。
            if($json_count3>=2&&$k!=20){//説明したバグの矯正した。高坂の場合24時、つまり20回目の中だけが1つだけだったのでk!=20で矯正。なお熊谷には効果なし。
           for($m=0;$m<$json_count3;$m++){
                 $minute[$i][$k][$m] = $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"][$m]["Minute"];//echo "&nbsp;";//count3だけ回すことで時刻表の分単位のデータを格納していく。
           }}
           else{
            $minute[$i][$k][0] = $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"]["Minute"];//普通に1個しかない場合は22行に記載してあるルールにより[$m]を消去することで格納。なお高坂に効果はないが熊谷にはある模様。
           }
             $m2[$i][$k] = $m;//それぞれの線の時間で何回分単位を回したか記憶。
            //echo  "&nbsp;";
       }
       $k2[$i] = $k;//それぞれの線で何回時間を回したか記憶。
       //echo $arr2["ResultSet"]["TimeTable"]["HourTable"][20]["MinuteTable"]["Minute"];
    }
   // echo $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"][$m]["Minute"];
    //echo $minute[0][0][0];

    //if ($arr === NULL) {
     //   return;
    //} else if ($json_count > 2) {
      //  $station_name = $arr['ResultSet']['Point'][0]['Station']['Name'];
        //$station_spell = $arr['ResultSet']['Point'][0]['Station']['Yomi'];
      //  $station_address = $arr['ResultSet']['Point'][0]['Prefecture']['Name'];
    //} else {
      //  $station_name = $arr['ResultSet']['Point']['Station']['Name'];
        //$station_spell = $arr['ResultSet']['Point']['Station']['Yomi'];
        //$station_address = $arr['ResultSet']['Point']['Prefecture']['Name'];
   // }
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
    <p>
        [インプットデータ]
    <form action="" method="POST">
　　　<select name="station">
　　　<option value="高坂" name = "station1">高坂</option> 
　　　<option value="北坂戸" name = "station2">北坂戸</option>
　　　<option value="熊谷" name = "station3">熊谷</option>
　　　<option value="鴻巣" name = "station3">鴻巣</option>
　　　</select>
     <input type ="submit"value ="送信" />
    </form>
    </p>
    <p>
        [レスポンスデータ]<BR>
        <?php
        //print "駅名 :";
        //echo $station_name;
        //echo "<br />";
        //print "読み方 :";
        //echo $station_spell;
        //echo "<br />";
        //print "所在県 :";
        //echo $station_address;
        //echo "<br />";

        //あとは上で格納して行ったのを順番に表示させていくだけ。
        //参考は”https://docs.ekispert.com/v1/api/operationLine/timetable.html”のリクエストレスポンス、サンプルコードのみ。
        print "駅名 :";
        echo $name; 
        echo "<br />";echo "<br />";

        for($i2 = 0;$i2 < $i; $i2++){
            echo $route[$i2];
            echo $destination[$i2];
            print "方面行き";
            echo "<br />";

            for($k3=0;$k3< $k2[$i2];$k3++){
                echo $hour[$i2][$k3];
                echo "&nbsp;";
                print ":";
                echo "&nbsp;";
                for($m3=0;$m3<$m2[$i2][$k3];$m3++){
                    echo $minute[$i2][$k3][$m3];
                    echo "&nbsp;";
                }
                echo "<br />";
            }
            echo "<br />";
        }
        ?>
    </p>
</body>

</html>