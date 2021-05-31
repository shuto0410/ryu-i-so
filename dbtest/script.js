var bus_time;
var bus_type;

function updatedata(){
  var request = new XMLHttpRequest();
  request.open("POST", "send_data.php", true);
  request.responseType = 'json';
  request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
  request.send('select_station=' + encodeURIComponent(document.getElementById("select_station").value));

  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          data = request.response;
          console.log(data);
          bus_type = data.TypeCode;
          document.getElementById('schedule_type').innerHTML = data.ScheduleType;
          document.getElementById('station_name').innerHTML = data.StationName;
          document.getElementById('but_time').innerHTML = data.BusTime;
          bus_time = data.BusTime;
      }
  }
}

window.onload = updatedata;
window.addEventListener("load", function(){
  document.getElementById("select_station").addEventListener("change", updatedata, false);
});

time();

function time() {
  if(bus_type == "3"){
    document.querySelector("#timer").innerHTML = "運休です";
  }
  else if(bus_type == "4"){
    document.querySelector("#timer").innerHTML = "特別ダイヤです";
  }

  if(bus_time != null){
    var bus = bus_time.split(':');
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    hours = Number(bus[0]) - hours;
    minutes = Number(bus[1]) - minutes - 1;
    if(minutes < 0){
      hours = hours - 1;
      minutes = minutes + 60;
    }
    seconds = 60 - seconds;
    if(hours < 0 || minutes < 0 || seconds < 0) updatedata();
    else{
      if(0 <= hours && hours <= 9) hours = "0" + hours;
      if(seconds == 60){
        seconds = "00";
        minutes = minutes + 1;
      }
      else if(seconds <= 9) seconds = "0" + seconds;
      if(minutes <= 9) minutes = "0" + minutes;

      var countdown = hours + ':' + minutes + ':' + seconds;
      document.querySelector("#timer").innerHTML = countdown;
    }
  }
}

setInterval('time()', 1000);
