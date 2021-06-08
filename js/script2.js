var bus_time;
var bus_type;

var data;
function get_schedule(){
  var request = new XMLHttpRequest();
  request.open("POST", "dbtest/bus_schedule.php", true);
  request.responseType = 'json';
  request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
  request.send('select_station=' + encodeURIComponent(document.getElementById("bus_timer_select").value));

  request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
          data = request.response;
          console.log(data);
          if(data !== null){
            clean_table();
            write_schedule();
          }
      }
  }
}

function clean_table(){
  var table = document.querySelector(".bus_schedule_table");
  for(let i = 0; i < table.rows.length; i++){
    table.rows[i].cells[1].innerText = "";
  }
}

function write_schedule(){
  var obj = document.getElementById("bus_timer_select");
  var idx = obj.selectedIndex;
  document.querySelector(".destination").innerHTML = obj.options[idx].text;
  var station = document.getElementById("bus_timer_select").value;
  var table = document.querySelector(".bus_schedule_table");
  var hours_tmp = table.rows;
  var hours = [];
  for(let i = 0; i < hours_tmp.length; i++){
    hours[i] = hours_tmp[i].innerText.replace("\t", "");
  }

  for(let i = 0; i < data.length - 1; i++){
    var time = data[i].split(':');
    var index = hours.indexOf(time[0]);
    table.rows[index].cells[1].insertAdjacentHTML('beforeend', time[1] + "&emsp;");
  }
}

window.addEventListener("load", get_schedule());

const select = document.getElementById("bus_timer_select");
select.addEventListener('change', get_schedule);
