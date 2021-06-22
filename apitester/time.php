<?php
if ($_POST["station"]) {

 $arr_data = $_POST["station"];
 $count=0;
 $count1=0;
 $sum=0;
 $valf="";
    $name_sql="";
 $time_sql="";

 foreach ( $arr_data as $key => $val ){
     
    if($count!=0){
        $time_sql=$time_sql.",";
        $name_sql="(".$valf."-".$val.")";
        
        $url0='https://api.ekispert.jp/v1/json/search/course/plain?key=AAHVX4RuL6EMRTeS&plane=false&shinkansen=false&bus=false&from=';
        $url1=$url0.$valf;
        $url2='&to=';
        $url=$url1.$url2.$val;
       //echo $url;
        //print"<BR>";
        $json = file_get_contents($url);
        $arr = json_decode($json, true);
        foreach($arr['ResultSet']['Course']['Route'] as $time){
          //  echo $time=$route;
           // $sum+=$time;
          //  $count1++;}
            $time2 = $time['timeOnBoard'];
            $time_sql="(".$time2.",".")";
       // print"<BR>";}
        }
        
        //['ResultSet']['Course']['Route']中のtimeOnBoardをとれさえすれば良いのだがうまくいかない。
    
        print_r($name_sql);
        print_r($time_sql);
    }
     $count++;
     $valf = $val;
     
     print"<BR>";
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
    発車駅
    <select name="station[0]">
    <option value="高坂">高坂</option>
    <option value="北坂戸">北坂戸</option>
    <option value="熊谷">熊谷</option>
    <option value="鴻巣">鴻巣</option>
    </select>
    <BR>
    経由駅
    <input type = "text" name = "station[1]">
    <BR>
    到着駅
     <input type = "text" name = "station[2]">
     <BR>
    <input type ="submit"value ="送信" />
    </form>

</body>

</html>


