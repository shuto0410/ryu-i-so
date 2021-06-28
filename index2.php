<!DOCTYPE html>
<html>

<head>
    <!--  -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" media="all" href="css/style2.css">
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Ryu-i-so | RD BUS</title>
</head>

<body>
    <header class="header">
        <a href="index.html" class="header_logo"><img src="images/logo.png" alt="logo"></a>
        <nav class="header_nav">
        </nav>
    </header>
    <div class="container">

        <section class="bus">
            <div class="bus_timer">
                <div class="bus_timer_top">
                    <select class="bus_timer_select" id="bus_timer_select">
                    </select>
                    <span>発車まで</span>
                </div>
                <div class="bus_timer_center">
                    <div class="bus_timer_station">
                        <p class="bus_timer_time" id="bus_timer_time">00:00:00</p>
                    </div>
                </div>
                <div class="bus_timer_bottom">
                    <span>次発まで</span>
                    <p class="bus_timer_next_time">00:00:00</p>
                </div>
            </div>

            <div class="horizontal_line"></div>

            <div class="bus_schedule">
                <div class="bus_schedule_title">
                    <p>大学発</p>
                    <p class="destination">高坂駅行き</p>
                </div>
                <table class="bus_schedule_table">
                    <?php
                    for($i = 8; $i <= 22; $i++){
                      print("<tr>");
                      print("<th>");
                      printf("%02d", $i);
                      print("</th>");
                      print("<td></td>");
                      print("</tr>");
                    }
                    ?>
                </table>
            </div>
        </section>

        <div class="vertical_line" id="vl01"></div>
        <div class="horizontal_line outer_hl" id="hl01"></div>

        <section class="train">
            <div class="departure_station">
                <div class="departure_station_top">
                    <div class="line_direction" id="line_left">寄居方面</div>
                    <div class="station_name">高坂駅</div>
                    <div class="line_direction" id="line_right">池袋方面</div>
                </div>

                <div class="horizontal_line"></div>

                <div class="train_time">
                    <div class="train_left">
                        <p class="train_type" id="train_left_type">準急　森林公園行</p>
                        <div class="train_time_time">
                            <p class="train_departure_time" id="left_time">13:00</p>
                            <span>発</span>
                        </div>
                    </div>
                    <div class="train_right">
                        <p class="train_type" id="train_right_type">急行　池袋行</p>
                        <div class="train_time_time">
                            <p class="train_departure_time" id="right_time">13:00</p>
                            <span>発</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="horizontal_line station_line"></div>

            <div class="train_schedule">
                <div class="tab_wrap">
                    <input type="radio" name="tab_btn" id="tab1" checked>
                    <input type="radio" name="tab_btn" id="tab2">

                    <div class="tab">
                        <label class="tab_label" for="tab1" id="tb1">寄居方面</label>
                        <label class="tab_label" for="tab2" id="tb2">池袋方面</label>
                    </div>
                    <div class="train_suchedule_panel">
                        <div class="schedule_panel" id="panel1">
                            <div class="grid_panel">
                                <table class="train_schedule1 t_sche" id="down_schedule_left">
                                    <?php
                                    for($i = 4; $i <= 14; $i++){
                                      print("<tr>");
                                      print("<th>");
                                      printf("%02d", $i);
                                      print("</th>");
                                      print("<td></td>");
                                      print("</tr>");
                                    }
                                    ?>
                                </table>
                                <div class="vertical_line"></div>
                                <table class="train_schedule2 t_sche" id="down_schedule_right">
                                    <?php
                                    for($i = 15; $i <= 24; $i++){
                                      print("<tr>");
                                      print("<th>");
                                      if($i == 24) printf("00", $i);
                                      else printf("%02d", $i);
                                      print("</th>");
                                      print("<td></td>");
                                      print("</tr>");
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <div class="schedule_panel" id="panel2">
                            <div class="grid_panel">
                                <table class="train_schedule1 t_sche">
                                    <?php
                                    for($i = 4; $i <= 14; $i++){
                                      print("<tr>");
                                      print("<th>");
                                      printf("%02d", $i);
                                      print("</th>");
                                      print("<td></td>");
                                      print("</tr>");
                                    }
                                    ?>
                                </table>
                                <div class="vertical_line"></div>
                                <table class="train_schedule2 t_sche">
                                    <?php
                                    for($i = 15; $i <= 24; $i++){
                                      print("<tr>");
                                      print("<th>");
                                      if($i == 24) print("00");
                                      else printf("%02d", $i);
                                      print("</th>");
                                      print("<td></td>");
                                      print("</tr>");
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="vertical_line" id="vl02"></div>
        <div class="horizontal_line outer_hl" id="hl02"></div>

        <section class="route">
            <div class="route_stop">
                <div class="stop_station">高坂駅まで</div>
                <div class="stop_time">00:17:52</div>
            </div>
            <div class="route_vertical_line"></div>
            <div class="route_stop">
                <div class="stop_station">池袋駅まで</div>
                <div class="stop_time">00:53:52</div>
            </div>
            <div class="route_vertical_line"></div>
            <div class="route_stop">
                <div class="stop_station">東京駅まで</div>
                <div class="stop_time">01:09:52</div>
            </div>
            <div class="route_vertical_line"></div>
            <div class="route_stop">
                <div class="stop_station">鎌倉駅まで</div>
                <div class="stop_time">02:07:52</div>
            </div>
        </section>
    </div>
    <button  id = "sel">ボタン</button>
    <!-- <script src="js/script.js"></script> -->
    <!-- <script src="js/script2.js"></script> -->
    <script src="js/train_time_table.js"></script>
</body>

</html>
