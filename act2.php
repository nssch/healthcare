<?php
//セッションスタート
session_start();

//関数ファイル読み込み
include('functions.php');
checkSessionid();

//セッション変数取得
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    exit('sessionerror');
}

// if (isset($_SESSION['lastweight'])) {
//     $lastweight = $_SESSION['lastweight'];
// } else {
//     $lastweight = 0;
//     //exit('sessionerror2');
// }
// if (isset($_SESSION['carolie'])) {
//     $carolie = $_SESSION['carolie'];
// } else {
//     $carolie = 0;
//     //exit('sessionerror2');
// }

//データベースに接続
$pdo = connectToDb();

//最近の体重を取得する
$sql = 'SELECT weight FROM weight_table WHERE user_id=:id ORDER BY date DESC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$result = $stmt->execute();
if ($result == false) {
    //SQL実行時にエラーがある場合
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lastweight = $result['weight'];
    }
    $_SESSION['lastweight'] = $lastweight;
}

//カロリー計算する
$sql2 = 'SELECT SUM(last_weight) FROM act_table WHERE user_id=:id';
$statement = $pdo->prepare($sql2);
$statement->bindValue(':id', $user_id, PDO::PARAM_INT);
$res = $statement->execute();
if ($res == false) {
    //SQL実行時にエラーがある場合
    $error = $statement->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    while ($res = $statement->fetch(PDO::FETCH_ASSOC)) {
        $sum_weight = $res['SUM(last_weight)'];
    }
    $carolie = $sum_weight * 1.05;
}

//選択したメニューを表示する
$sql3 = 'SELECT description FROM mets_table INNER JOIN user_table ON mets_table.id = user_table.mets_id WHERE user_table.id=:id';
$st = $pdo->prepare($sql3);
$st->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $st->execute();
if ($status == false) {
    //SQL実行時にエラーがある場合
    $error = $st->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    while ($status = $st->fetch(PDO::FETCH_ASSOC)) {
        $menu = $status['description'];
    }
}


?>
<!DOCTYPE html>
<html lang="en">

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
    <!-- <link type="text/css" src="https://cdnjs.com/libraries/bttn.css" />
    <link type="text/css" src="bttn.min.css" /> -->

    <!-- サービスワーカーの登録準備 -->
    <!-- <script>
        window.addEventListener('load', () => {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register("/sw.js")
                    .then(registration =>
                        console.log("success,scope:", registration.scope))
                    .catch((err) =>
                        console.warn("failed:", err));
            }
        });
    </script> -->
</head>

<body id="wrapper">
    <header>
        <h1>Record</h1>
    </header>

    <div>
        <div class="textarea">
            <div>
                <h2><?= $menu ?></h2>

            </div>

            <form action="act_insert.php" method="POST">
                <input type="submit" value="DONE" class="mbtn" name="done">
            </form>

        </div>

        <div class="chartarea">
            <canvas id="myPieChart" width="250" height="250"></canvas>


            <div class="timer-a" style="color: red; font-size:2em;">0</div>kcal消費
        </div>

        <!-- <div class="plus">
            <button class="plusbtn">+</button>
        </div> -->
    </div>
    <div class="plus">
        <a id="fab" href="menu2.php">
            <i class="fas fa-plus" fa-4x></i>
        </a>
    </div>

    <nav class="tab-bar">
        <ul>
            <li><a href="act2.php"><i class="fas fa-walking"></i><span class="category-name">Record</span></a></li>
            <li><a href="weight_graph.php"><i class="fas fa-chart-line"></i><span class="category-name">Weight</span></a></li>
            <li><a href="#"><i class="fas fa-crown"></i><span class="category-name">Ranking</span></a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="category-name">Logout</span></a>
            </li>

        </ul>
    </nav>

    <script src="iscroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script src="./jquery-countTo.min.js"></script>

    <script>
        $(function() {
            var myscroll = new IScroll("#wrapper");
        });

        Chart.pluginService.register({
            beforeDraw: function(chart) {
                if (chart.config.options.elements.center) {
                    //Get ctx from string
                    var ctx = chart.chart.ctx;

                    //Get options from the center object in options
                    var centerConfig = chart.config.options.elements.center;
                    var fontStyle = centerConfig.fontStyle || 'Arial';
                    var txt = centerConfig.text;
                    var color = centerConfig.color || '#000';
                    var sidePadding = centerConfig.sidePadding || 20;
                    var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
                    //Start with a base font of 30px
                    ctx.font = "30px " + fontStyle;

                    //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                    var stringWidth = ctx.measureText(txt).width;
                    var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                    // Find out how much the font can grow in width.
                    var widthRatio = elementWidth / stringWidth;
                    var newFontSize = Math.floor(30 * widthRatio);
                    var elementHeight = (chart.innerRadius * 2);

                    // Pick a new font size so it will not be larger than the height of label.
                    var fontSizeToUse = Math.min(newFontSize, elementHeight);

                    //Set font settings to draw it correctly.
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                    var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                    ctx.font = fontSizeToUse + "px " + fontStyle;
                    ctx.fillStyle = color;

                    //Draw text in center
                    ctx.fillText(txt, centerX, centerY);
                }
            }
        });

        $(function() {
            $.getJSON('http://localhost/healthcare/act.php', function(data) {
                //console.log(data);
                //グラフ描画
                var ctx = document.getElementById("myPieChart")
                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            backgroundColor: [
                                "#3C00FF",
                                "#87cefa"
                            ],
                            data: data.data
                        }]
                    },
                    options: {
                        // percentageInnerCutout: 90,
                        cutoutPercentage: 90,
                        // circumference: 1 * Math.PI,
                        // rotation: 1 * Math.PI,

                        elements: {
                            center: {
                                text: data.text,
                                color: '#36A2EB', //Default black
                                fontStyle: 'Helvetica', //Default Arial
                                sidePadding: 40 //Default 20 (as a percentage)
                            }
                        }
                    }


                });


            });


        });


        $(function() {
            $(".timer-a").countTo(<?php echo ($carolie); ?>, {
                "duration": 1
            });

        });
    </script>

</body>

</html>