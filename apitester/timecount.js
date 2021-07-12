//現在時刻のデータ
var dToday = new Date();

// 時・分を取得する
var hour = dToday.getHours();
var minute = dToday.getMinutes();
//時刻表の仮想時間データ
let stationtime = [[14, 50], [15, 13], [15, 35], [20, 10], [20, 40], [21, 49]];
//平均経路時間から得られたデータ
let averagetime = 59;
//console.log("stationtime");


//現在時刻と比較して、時間を割り出す
function Determine(hour, minute, stationtime) {

    let nowtime = [hour, minute];


    for (let i = 0; i < stationtime.length; i++) {
        if (nowtime[0] == stationtime[i][0]) {
            console.log("stationtime", stationtime[i]);
            if (nowtime[1] <= stationtime[i][1]) {
                return stationtime[i];
            }
        }
        else if (nowtime[0] < stationtime[i][0]) {
            // ["12","20"]とかを返す
            return stationtime[i];
        }
    }
}

function sum_time(stationtime, averagetime) {
    stationtime[1] = Number(stationtime[1]) + Number(averagetime);
    if (stationtime[1] >= 60) {
        stationtime[0]++;
        stationtime[1] = stationtime[1] - 60;
    }
    return stationtime;
}
console.log(sum_time(Determine(hour, minute, stationtime), averagetime));
//console.log(Determine(hour,minute,stationtime,averagetime));

