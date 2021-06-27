var modal = document.getElementById("hidden_modal");
var open = document.getElementById("btn_open_modal");
var close = document.getElementById("close_modal");
var input_station_to = document.getElementById("station_to");
var upper_limit = 3;
var i = 1;


function no_scroll(event) {
    event.preventDefault();
}
// モーダルウィンドウの表示
function open_modal() {
    modal.classList.remove('hidden');
    document.addEventListener('touchmove', no_scroll, {passive:false});
    document.addEventListener('mousewheel', no_scroll, {passive:false});
}
open.addEventListener('click', open_modal);
// モーダルウィンドウの非表示
function close_modal() {
    modal.classList.add('hidden');
    document.removeEventListener('touchmove', no_scroll, {passive:false});
    document.removeEventListener('mousewheel', no_scroll, {passive:false});
}
close.addEventListener('click', close_modal);


//入力フォームの追加
function add_form() {
    if(i <= upper_limit){
        var input_data = document.createElement('input');
        input_data.type = 'text';
        input_data.id = 'station_via' + i;
        input_data.placeholder = '経由駅を入力';
        input_data.classList.add('station_input');
        var parent = document.getElementById('via_inputs');
        parent.appendChild(input_data);
        i++ ;
        if(i == upper_limit + 1){
            document.getElementById("add_via_input").style.visibility = "hidden";
        }
    }
    if(1 < i){
        document.getElementById("del_via_input").style.visibility = "visible";
    }
}
//入力フォームの削除
function del_form() {
    if(1 < i){
        var id = 'station_via' + (i - 1);
        const classclear = document.getElementById(id);
        classclear.classList.remove('station_input');
        classclear.remove();
        i--;
        if(i == upper_limit){
            document.getElementById("add_via_input").style.visibility = "visible";
        }
    }
    if(i == 1){
        document.getElementById("del_via_input").style.visibility = "hidden";
    }
}


function check_string($this){
    let string = $this.value;
}

function change_display(){
    if(input_station_to.value != ""){
        document.getElementById("input_warning").style.display = "none";
        document.getElementById("send_to_via").style.display = "block";
    }
    else{
        document.getElementById("input_warning").style.display = "block";
        document.getElementById("send_to_via").style.display = "none";
    }
}

input_station_to.addEventListener('change', change_display);

function make_station_index(){
    var to_station = document.getElementById("station_to").value;
    //入力された駅名を配列に格納
    var stations = [];
    var count = 0;
    stations[count] = to_station;
    count++;
    for(let j = 0; j < i; j++){
        var station_form_id = 'station_via' + j;
        var station = document.getElementById(station_form_id).value
        if(station != ""){
            stations[count] = station;
            count++;
        }
    }
    return stations;
}

//経路部分の時刻を書き換える用（仮）
function write_train_time(train_schedule){
    console.log(train_schedule);
    //dbtest/dbtest.phpから送信されたデータをコンソール上に表示しています
}

//到着駅・経由駅送信
function send_to_via(user_stations){
    var to_station = document.getElementById("station_to").value;
    //ここからphpとの送受信設定
    var request = new XMLHttpRequest();
    request.open("POST", "dbtest/dbtest.php", true); //このjsファイルからの相対パスでphpファイルを指定可能。
    request.responseType = 'json';
    request.setRequestHeader("content-type", "application/json");//JSON用の設定
    var json = JSON.stringify(user_stations);//配列をJSONに変換
    request.send(json);//PHPへデータ送信

    //受信したデータの表示
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var train_data = request.response; //dbtest.phpからのechoを取得
            //今回はただのtext形式になってます。
            write_train_time(train_data);
        }
    }
}

//経路の表示を消す
function clean_train_route(parent){
    let child = parent.querySelector("div");
    while(child){
        child.remove();
        child = parent.querySelector("div");
    }
}
//経路を書き込む
function write_user_route(user_stations){
    let parent = document.getElementById("route_via_frame");
    var train_clone = document.getElementById("rounte_via_elements");
    var bar_clone = document.getElementById("connect_stations");
    clean_train_route(parent);

    let bus_station = document.getElementById("bus_timer_select");
    let bus_station_name = bus_station.options[bus_station.selectedIndex].text;
    bus_station_name = bus_station_name.replace("駅行き", "");
    user_stations.unshift(bus_station_name);

    var count = 0;
    for(count; count < user_stations.length; count++){
        var train_clone_tmp = train_clone.cloneNode(true);
        var bar_clone_tmp = bar_clone.cloneNode(true);
        train_clone_tmp.children[1].innerHTML = user_stations[count];
        parent.appendChild(train_clone_tmp);
        if(count != user_stations.length - 1){
            parent.appendChild(bar_clone_tmp);
        }
    }
}

//入力された駅名を表示する欄の中身を削除
function clean_via_to_stations(parent){
    let child = parent.querySelector("p");
    while(child){
        child.remove();
        child = parent.querySelector("p");
    }
}
//入力された駅名を表示
function write_user_station(user_stations){
    let parent = document.getElementById('user_station_via');
    clean_via_to_stations(parent);
    var count = 0;
    document.getElementById("to_station_name").innerHTML = user_stations[count];
    count++;
    for(count; count < user_stations.length; count++){
        var new_via = document.createElement('p');
        new_via.innerHTML = user_stations[count];
        new_via.classList.add('user_station>p');
        parent.appendChild(new_via);
    }
}

//送信ボタンのアニメーション用
focusMethod = function get_focus(){
    document.getElementById("send_to_via").focus();
}

//決定ボタンが押されたときのイベント
var send = document.getElementById("send_to_via");
send.addEventListener('click', function(){
    var stations_index = make_station_index();
    send_to_via(stations_index);
    write_user_route(stations_index);
    write_user_station(stations_index);

    setTimeout('close_modal();', 2000);
    // close_modal();//モーダル非表示
});
