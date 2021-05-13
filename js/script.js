const select = document.getElementById('bus_timer_select');

select.addEventListener('change', function() {
    var stations = document.getElementsByClassName('bus_timer_station');
    var val = this.value;
    for (var i = 0; i < stations.length; i++) {
        stations[i].style.display = (i === parseInt(val)) ? 'block' : 'none';
    }
});

window.onload = function() {
    var stations = document.getElementsByClassName('bus_timer_station');
    var val = 0;
    for (var i = 0; i < stations.length; i++) {
        stations[i].style.display = (i === parseInt(val)) ? 'block' : 'none';
    }
}

time();

function time() {
    var now = new Date();
    document.querySelector(".bus_timer_time").innerHTML = now.toLocaleTimeString();
}
setInterval('time()', 1000);