const select = document.getElementById('select_station');
select.addEventListener('change', function(){
    var stations = document.getElementsByClassName('station');
    var val = this.value;
    for(var i = 0; i < stations.length; i++){
        stations[i].style.display = (i === parseInt(val)) ? 'block' : 'none';
    }
});

window.onload = function(){
    var stations = document.getElementsByClassName('station');
    var val = 0;
    for(var i = 0; i < stations.length; i++){
        stations[i].style.display = (i === parseInt(val)) ? 'block' : 'none';
    }
}