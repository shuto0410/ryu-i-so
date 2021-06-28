
// data = ["10:00", "11:10", "12:20", "12:30", "12:40", "13:40", "16:40", "16:50"];

function get_schedule() {
    var request = new XMLHttpRequest();
    request.open("POST", "dbtest/ajax_getData.php", true);
    request.responseType = 'json';
    request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
    request.send('select_station=' + encodeURIComponent(document.getElementById("bus_timer_select").value));
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var data;
            data = request.response;
            console.log("response_data",data);
            if (data !== null) {
                clean_table("down_schedule_left");
                write_schedule(data,"down_schedule_left");
                console.log("左後データ",data);
                clean_table("down_schedule_right");
                write_schedule(data,"down_schedule_right");
            }
        }
    }
}

function clean_table(table_id) {
    var table = document.getElementById(table_id);
    for (let i = 0; i < table.rows.length; i++) {
        table.rows[i].cells[1].innerText = "";
    }
}

function write_schedule(data,table_id) {
    var table = document.getElementById(table_id);
    var hours_tmp = table.rows;
    var hours = [];
    for (let i = 0; i < hours_tmp.length; i++) {
        hours[i] = hours_tmp[i].innerText.replace("\t", "");
    }

    for (let i = 0; i < data.length; i++) {
        var time = data[i].split(':');
        var index = hours.indexOf(time[0]);
        if(index >= 0)  {
            table.rows[index].cells[1].insertAdjacentHTML('beforeend', time[1] + "&emsp;");
        }
    }
}

window.addEventListener("load", get_schedule());
// const select = document.getElementById("bus_timer_select");
// select.addEventListener('change', get_schedule);
