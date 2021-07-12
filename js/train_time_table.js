
function get_schedule2(UpOrDown) {
    console.log("BUSTYPE",document.getElementById("bus_timer_select").value);
    var request = new XMLHttpRequest();
    request.open("POST", "dbtest/ajax_getData.php", true);
    request.responseType = 'json';
    request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");
    // ここでセレクトデータを送っている
    request.send('select_station=' + encodeURIComponent(document.getElementById("bus_timer_select").value)+'&UpOrDown=' + UpOrDown);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var data;
            data = request.response;
            if (data !== null) {
                // TODO:このidをつけると表示される
                create_schedule(data,UpOrDown+"_schedule_left",UpOrDown);
                create_schedule(data,UpOrDown+"_schedule_right",UpOrDown);
                train_info(Determine(split_time(data)),UpOrDown);
            }
        }
    }
}



// 
function create_schedule(data,table_id,line_kind){
    write_station_name();
    clean_table2(table_id);
    // FIXME:本来ならup,downを分けるつもり
    // write_schedule2(data[line_kind],table_id);
    write_schedule2(data,table_id);
}

function write_station_name(){

    switch (Number(document.getElementById("bus_timer_select").value)) {
        case 0:
            station_name = "高坂駅";
            down_station_name = "寄居方面";
            up_station_name = "池袋方面";
            break;
        case 1:
            station_name = "北坂戸駅";
            down_station_name = "寄居方面";
            up_station_name = "池袋方面";
            break;
        case 2:
            station_name = "熊谷駅";
            down_station_name = "高崎方面";
            up_station_name = "小田原方面";
            break;
        case 3:
            station_name = "鴻巣駅";
            down_station_name = "高崎方面";
            up_station_name = "小田原方面";
            break;
    
        default:
            station_name = "高坂駅";
            break;
    }
    document.getElementById('station_name').innerHTML = station_name;
    document.getElementById('line_left').innerHTML = down_station_name;
    document.getElementById('line_right').innerHTML = up_station_name;
}

// テーブルを初期化
function clean_table2(table_id) {
    var table = document.getElementById(table_id);
    for (let i = 0; i < table.rows.length; i++) {
        table.rows[i].cells[1].innerText = "";
    }
}

function write_schedule2(data,table_id) {
    var table = document.getElementById(table_id);
    var hours_tmp = table.rows;
    var hours = [];
    for (let i = 0; i < hours_tmp.length; i++) {
        hours[i] = hours_tmp[i].innerText.replace("\t", "");
    }

    for (let i = 0; i < data.length-1; i++) {
        var time = data[i].split(':');
        var index = hours.indexOf(time[0]);
        if(index >= 0)  {
            table.rows[index].cells[1].insertAdjacentHTML('beforeend', time[1] + "&emsp;");
        }
    }
}

// ["12:26","22:33"]を[12,26],[22,33]
function split_time(time_data){
    var time=[];
    for (let i = 0; i < time_data.length-1; i++) {
        time.push(time_data[i].split(':'));
    }
    return time;
}

//現在時刻と比較して、時間を割り出す
function Determine(stationtime) {
    //現在時刻のデータ
    var dToday = new Date();
    // 時・分を取得する
    var hour = dToday.getHours();
    var minute = dToday.getMinutes();
    let nowtime = [hour, minute];
    for (let i = 0; i < stationtime.length; i++) {
        if (nowtime[0] == stationtime[i][0]) {
            if (nowtime[1] <= stationtime[i][1]) {
                // FIXME:デバック
                console.log("一番近い時間",stationtime[i]);
                return i;
            }
        }
        else if (nowtime[0] < stationtime[i][0]) {
            console.log("一番近い時間",stationtime[i]);
            // FIXME:デバック
            return i;
        }
    }
}

// 引数に、どの駅か、上りor下り
function train_info(i,UpOrDown){
    console.log("set_time_UD",UpOrDown);
    if (UpOrDown =='down') {
        LeftOrRight = 'left';
    }else{
        LeftOrRight = 'right';
    }
    
    console.log("LEFTORRIGHT",LeftOrRight);
    $.ajax({
        type: "POST",
        url: "dbtest/train_info.php",
        //TODO:上りと下をどうにかする
        data: {
            // 送るデータをすでにwhere絞っとく
            "select_station": encodeURIComponent(document.getElementById("bus_timer_select").value),
            "UpOrDown":UpOrDown,
        }}).done((data) => {
            console.log("set_time_data",data[i]);
            console.log("set_time_LR",LeftOrRight);
            //成功した場合の処理
            time_data = data[i][0].split(":");
            document.getElementById(LeftOrRight+'_time').innerHTML = time_data[0]+":"+time_data[1];
            document.getElementById('train_'+LeftOrRight+'_type').innerHTML = data[i][1]+" "+data[i][2]+"行";
        })
        .fail((data) => {
            //失敗した場合の処理
            console.log("fail",data.responseText);
        });
}



var dToday = new Date();
var minute_tmp = dToday.getMinutes();

function check_time(){
    var dToday = new Date();
    var minute = dToday.getMinutes();
    if(minute!=minute_tmp){
        create_time_schedule();
        minute_tmp = minute;
    }
}

function create_time_schedule(){
get_schedule2("down");
setTimeout( function() {
    get_schedule2("up");
}, 1000 );
}

const select2 = document.getElementById("bus_timer_select");
select2.addEventListener("change", create_time_schedule);
window.addEventListener("load", create_time_schedule());
setInterval('check_time()', 1000);