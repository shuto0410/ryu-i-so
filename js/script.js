var bus_time;//次のバスの時刻を格納用
var bus_type;//バスのダイヤ情報(授業期間中ダイヤ、土曜日ダイヤ、etc.)格納用
var next_bus;//次の次のバスの時刻を格納用
var date;
var today;//日付が変わったことを判定する用

//次のバスの時刻を取得する関数。セレクトボックスで選択されている駅の、バスの時刻データを取得。
function updatedata(){
  date = new Date();
  today = date.getDate();//その日の日付を取得。ここで行う必要なかったかもです。
  var request = new XMLHttpRequest();//ajaxの機能
  request.open("POST", "dbtest/send_data.php", true);//アドレスを指定する部分だが、相対パスでも通信できる仕様のようです。
  request.responseType = 'json';//送られてくるデータ形式の指定
  request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
  request.send('select_station=' + encodeURIComponent(document.getElementById("bus_timer_select").value));
  //HTMLのセレクトボックス"bus_timer_select"の値をサーバーのphpにPOST

  request.onreadystatechange = function(){
    if(request.readyState == 4 && request.status == 200){
      data = request.response;
      console.log(data);
      bus_type = data.TypeCode;//バスのダイヤ情報(授業期間中ダイヤ、土曜日ダイヤ、etc.)
      bus_time = data.BusTime[0];//現在時刻から１番近いバスの時刻。何時何分何秒。(例: 09:46:00)
      next_time = data.BusTime[1];//現在時刻から２番近いバスの時刻。何時何分何秒。(例: 10:07:00)
    }
  }
}

//カウントダウンの数字部分を書き換える関数
function timer(){
  date = new Date();
  var tmp = date.getDate();
  if(today != tmp){//日付が変わったとき、データを更新
    updatedata();
  }
  //ここから、バスの運行ダイヤによって表示を変更
  if(bus_type == "3"){
    document.querySelector("#bus_timer_time").innerHTML = "運休です";
  }
  else if(bus_type == "4"){
    document.querySelector("#bus_timer_time").innerHTML = "特別ダイヤ";
  }
  else{
    if(bus_time == null){
      document.querySelector("#bus_timer_time").innerHTML = "運行終了";
      //その日の次のバスがもう無ければ運行終了を表示
    }
    else{
      var recent = time(bus_time);//time('次のバスの時刻')で残り時間を取得
      document.querySelector("#bus_timer_time").innerHTML = recent;
    }
    var next = time(next_time);//time('次の次のバスの時刻')で残り時間を取得
    document.querySelector(".bus_timer_next_time").innerHTML = next;
  }
  //ここまで
}

function time(schedule_time) {
    if(schedule_time != null){//サーバーからは、次のバスがなければnullが返されるのでそれを判定
      var bus = schedule_time.split(':');//バス時刻"00:00:00"を[時,分,秒]に分割
      var now = new Date();//現在時刻を取得
      var hours = now.getHours();//現在の"時"を取得
      var minutes = now.getMinutes();//現在の"分"を取得
      var seconds = now.getSeconds();//現在の"秒"を取得
      //ここからは、現在時刻からバスの時刻までのカウントダウンの計算
      hours = Number(bus[0]) - hours;
      minutes = Number(bus[1]) - minutes - 1;
      if(minutes < 0){
        hours = hours - 1;
        minutes = minutes + 60;
      }
      seconds = 60 - seconds;
      if(hours < 0 || minutes < 0 || seconds < 0){
        updatedata();
        return "00:00:00";
      }
      else{
        if(0 <= hours && hours <= 9) hours = "0" + hours;
        if(seconds == 60){
          seconds = "00";
          minutes = minutes + 1;
        }
        else if(seconds <= 9) seconds = "0" + seconds;
        if(minutes <= 9) minutes = "0" + minutes;

        var countdown = hours + ':' + minutes + ':' + seconds;
        return countdown;
      }
      //ここまで
    }
    else{
      return "00:00:00";//次のバスが無ければ(サーバーからのデータがnullなら)とりあえず戻り値として"00:00:00"
    }
}

window.onload = updatedata;
window.addEventListener("load", function(){
  //セレクトボックスが変更されたら、バスの時刻を更新
  document.getElementById("bus_timer_select").addEventListener("change", updatedata, false);
});

setInterval('timer()', 1000);//更新