var modal = document.getElementById('hidden_modal');
var open = document.getElementById('open_modal');
var close = document.getElementById('close_modal');

function noScroll(event) {
    event.preventDefault();
}
// モーダルウィンドウの表示
function openModal() {
    modal.classList.remove('hidden');
    document.addEventListener('touchmove', noScroll, {passive:false});
    document.addEventListener('mousewheel', noScroll, {passive:false});
}
open.addEventListener('click', openModal);
// モーダルウィンドウの非表示
function closeModal() {
    modal.classList.add('hidden');
    document.removeEventListener('touchmove', noScroll, {passive:false});
    document.removeEventListener('mousewheel', noScroll, {passive:false});
}
close.addEventListener('click', closeModal);


//入力フォームの追加
var i = 1;
function addForm() {
    if(i <= 3){
        var input_data = document.createElement('input');
        input_data.type = 'text';
        input_data.id = 'station_via' + i;
        input_data.placeholder = '経由駅を入力';
        input_data.classList.add('station_input_form');
        var parent = document.getElementById('via_form');
        parent.appendChild(input_data);
        i++ ;
    }
}
//入力フォームの削除
function delForm() {
    if(1 < i){
        var id = 'station_via' + (i - 1);
        const classclear = document.getElementById(id);
        classclear.classList.remove('station_input_form');
        classclear.remove();
        i--;
    }
}


// 到着駅・経由駅送信
function send_to_via() {
    var to_station = document.getElementById("station_to").value;
    //到着駅が未入力の場合
    if(to_station == ""){
        var warn_text = document.createElement('div');
        warn_text.id = 'to_station_is_null';
        warn_text.innerHTML = '入力必須';
        warn_text.classList.add('warning_text', 'station_input_form');
        var parent = document.getElementById('to_form');
        parent.appendChild(warn_text);
    }
    //到着駅が入力されている場合
    else{
        //警告が既に表示されている場合には警告を削除
        var tmp = document.getElementById('to_station_is_null');
        if(tmp){
            tmp.classList.remove('warning_text', 'station_input_form');
            tmp.remove();
        }
        //ここからphpとの送受信設定
        var request = new XMLHttpRequest();
        request.open("POST", "dbtest/dbtest.php", true); //このjsファイルからの相対パスでphpファイルを指定可能。
        request.responseType = 'text'; //受信する際の形式を設定JSONなども設定可能
        request.setRequestHeader("content-type", "application/x-www-form-urlencoded;charset=UTF-8");

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
        console.log(stations);
        //'station_to_via'の名前でPOSTしています。dbtest.phpで受け取っています。
        request.send('station_to_via=' + encodeURIComponent(stations)
        );

        //受信したデータの表示
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                data = request.response; //dbtest.phpからのechoを取得
                //今回はただのtext形式になってます。
                console.log(data); //phpに送ったデータをそのまま返してもらい送れていたか確認
            }
        }
    }
}

//決定ボタンが押されたときのイベント
var send = document.getElementById('send_to_via');
send.addEventListener('click', function(){
    send_to_via();//データ送信
    closeModal();//モーダル非表示
});
