<?php
if ($_POST['station']) {
    $station = $_POST['station'];
    //echo $station;
    $url1 = 'https://api.ekispert.jp/v1/json/operationLine/timetable?key=AAHVX4RuL6EMRTeS&stationName=';
    $url = $url1 . $station;
    //echo $url;
    $json = file_get_contents($url);
    // $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    //echo $json;
    //$arr = json_decode($json);
    //echo $arr->ResultSet->Point->Station->Yomi;
    $arr = json_decode($json, true);
    $json_count = count($arr["ResultSet"]["TimeTable"]);
    //echo $json_count;
    $name = $arr['ResultSet']['TimeTable'][0]['Station']['Name'];

    for($i = 0;$i < $json_count; $i++){
        $code[$i] = $arr['ResultSet']['TimeTable'][$i]['code'];
        $route[$i] = $arr['ResultSet']['TimeTable'][$i]['Line']['Name'];
        $destination[$i] = $arr['ResultSet']['TimeTable'][$i]['Line']['Direction'];
        
       $url2 = $url1.$station."&code=".$code[$i];
       //echo $url;
       $json2 = file_get_contents($url2);
       //echo $json2;
       $arr2 = json_decode($json2, true);

       $json_count2 =count($arr2["ResultSet"]["TimeTable"]["HourTable"]);
       //echo $json_count2;
       for($k=0;$k< $json_count2;$k++){
           $hour[$i][$k] = $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["Hour"];
            $json_count3 = count($arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"]);//echo "&nbsp;";
            if($json_count3>=2&&$k!=20){
           for($m=0;$m<$json_count3;$m++){
                 $minute[$i][$k][$m] = $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"][$m]["Minute"];//echo "&nbsp;";
           }}
           else{
            $minute[$i][$k][0] = $arr2["ResultSet"]["TimeTable"]["HourTable"][$k]["MinuteTable"]["Minute"];
           }
             $m2[$i][$k] = $m;
            //echo  "&nbsp;";
       }
       $k2[$i] = $k;
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



