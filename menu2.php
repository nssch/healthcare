<?php
//セッションスタート
session_start();

//関数ファイル読み込み
include('functions.php');
checkSessionid();

//データベース接続
$pdo = connectToDb();

//データベースからメニュー取得
$sql = 'SELECT*FROM mets_table ORDER BY mets ASC';
$stmt = $pdo->prepare($sql);
$result = $stmt->execute();


//表示
$view = '';
if ($result == false) {
    //SQL実行時にエラーがある場合
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    //SELECTデータの数だけ自動でループ
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="input-container">';
        $view .= '<input id="' . $result['id'] . '" class="radio-button" type="radio" name="menu" value="' . $result['id'] . '" data-message="' . $result['description'] . '" />';
        $view .= '<div class="radio-tile">';
        $view .= '<div class="icon walk-icon">';
        $view .= '<i class="fas fa-burn fa-4x"></i>';
        $view .= '</div>';
        $view .= '<label for="swim" class="radio-tile-label">' . $result['mets'] . '</label>';
        $view .= '</div>';
        $view .= '</div>';
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

</head>

<body id="wrapper">
    <header>
        <h1>Menu</h1>
    </header>

    <div class="container">
        <form action="menu_insert.php" method="POST" class="radio-tile-group">
            <?= $view ?>

            <div class="menu_btn">
                <button class="mbtn">習慣にする</button>
            </div>

        </form>
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
    <script>
        $(function() {
            var myscroll = new IScroll("#wrapper");
        });

        //radioボタン選択したとき
        function consoleMessage(elm) {
            console.log(elm.getAttribute("data-message"))
        }
        document.body.addEventListener('click', function(event) {
            if (event.srcElement.className == 'radio-button') {
                consoleMessage(event.srcElement);
            };
        });
    </script>

</body>

</html>