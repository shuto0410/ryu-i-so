var bus_time;
var bus_type;
var next_bus;

function updatedata(){
  var request = new XMLHttpRequest();
  request.open("POST", "dbtest/send_data.php", true);
  request.responseType = 'json';
  request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
  request.send('select_station=' + encodeURIComponent(document.getElementById("bus_timer_select").value));

  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          data = request.response;
          console.log(data);
          bus_type = data.TypeCode;
          bus_time = data.BusTime[0];
          next_time = data.BusTime[1];
          if(bus_type == "3"){
            document.querySelector("#bus_timer_time").innerHTML = "運休です";
          }
          else if(bus_type == "4"){
            document.querySelector("#bus_timer_time").innerHTML = "特別ダイヤ";
          }
      }
  }
}

window.onload = updatedata;
window.addEventListener("load", function(){
  document.getElementById("bus_timer_select").addEventListener("change", updatedata, false);
});

function timer(){
  var recent = time(bus_time);
  document.querySelector("#bus_timer_time").innerHTML = recent;
  var next = time(next_time);
  document.querySelector(".bus_timer_next_time").innerHTML = next;
}


function time(schedule_time) {
    if(schedule_time != null){
      var bus = schedule_time.split(':');
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
    }
}

setInterval('timer()', 1000);
