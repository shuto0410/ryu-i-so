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
                        <?php
                        ini_set('display_errors',1);
                        $conn = mysqli_connect("127.0.0.1", "ryu-i-so", "rdbus", "RD_bus") or die("Access failed.");
                        $res = mysqli_query($conn, "SELECT StationID, StationName FROM StationTable");
                        while($station = mysqli_fetch_array($res)){
                          print("<option value = $station[0]>");
                          print("$station[1]駅行き");
                          print("</option>");
                        }
                        ?>
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
            <button id="open_modal">変更</button>

            <div id="hidden_modal" class="hidden">
                <div id="modalbg" class="modalbg"></div>
                <div class="modal_content">
                    <span id="close_modal" class="close">X</span>
                    <div class="to_form station_form" id="to_form">
                        <p>到着駅</p>
                        <input type="text" maxlength="30" id="station_to" class="station_input_form" value="" placeholder="到着駅を入力" required>
                    </div>
                    <div class="via_form station_form" id="via_form">
                        <p>経由駅</p>
                        <input type="text" maxlength="30" id="station_via0" class="station_input_form" value="" placeholder="経由駅を入力">
                    </div>
                    <input type="button" value="+" onclick="addForm()">
                    <input type="button" value="-" onclick="delForm()">
                    <button type="submit" id="send_to_via">決定</button>
                </div>
            </div>
        </section>

    </div>
    <script src="js/script.js"></script>
    <script src="js/script2.js"></script>
    <script src="js/script3.js"></script>
</body>

</html>
