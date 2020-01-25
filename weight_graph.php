<?php
//セッションスタート
session_start();
//var_dump($_SESSION);
//関数ファイル読み込み、ログイン状態確認
include('functions.php');
checkSessionid();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <!--最小限のビューポート設定-->
    <meta name="viewport" content="width=device-width">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/test.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

</head>

<body id="wrapper">
    <header>
        <h1>Weight</h1>
    </header>

    <div class="container2">
        <form action="weight_insert.php" method="POST">
            <input type="number" name="weight" id="weight">
            <button type="submit">記録</button>
        </form>

        <div>
            <canvas id="myChart" width="250" height="300"></canvas>
        </div>
    </div>





    <nav class="tab-bar">
        <ul>
            <li><a href="act2.php"><i class="fas fa-walking"></i><span class="category-name">Record</span></a></li>
            <li><a href="weight_graph.php"><i class="fas fa-chart-line"></i><span class="category-name">Weight</span></a></li>
            <li><a href="#"><i class="fas fa-crown"></i><span class="category-name">Ranking</span></a></li>
            <!-- <li><a href="#"><i class="fas fa-cog"></i><span class="category-name">Setting</span></a></li> -->
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="category-name">Logout</span></a></li>
        </ul>
    </nav>

    <script src="iscroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script>
        $(function() {
            $.getJSON('http://localhost/healthcare/weight.php', function(data) {
                console.log(data);
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Weight',
                            data: data.data,
                            borderColor: "#3C00FF",
                            backgroundColor: "#87cefa"
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    suggestedMax: 100,
                                    suggestedMin: 0,
                                    stepSize: 5,
                                    callback: function(value, index, values) {
                                        return value + 'kg'
                                    }
                                }
                            }]
                        }

                    }

                });

            });
        });
        $(function() {
            var myscroll = new IScroll("#wrapper");
        });
    </script>

</body>

</html>