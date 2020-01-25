<?php
//セッションスタート
session_start();

//関数ファイル読み込み
include('functions.php');
checkSessionid();

//データベース接続
$pdo = connectToDb();

//データベースからメニュー取得
$sql = 'SELECT*FROM mets_table';
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
        $view .= '<input id="' . $result['id'] . '" class="radio-button" type="radio" name="menu" value="' . $result['id'] . '" />';
        $view .= '<div class="radio-tile">';
        $view .= '<div class="icon walk-icon">';
        //$view .= '<i class="fas fa-walking fa-4x"></i>';
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

            <!-- <div class="input-container">
                <input id="walk" class="radio-button" type="radio" name="radio" />
                <div class="radio-tile">
                    <div class="icon walk-icon">
                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                        </svg>
                    </div>
                    <label for="walk" class="radio-tile-label">Walk</label>
                </div>
            </div>

            <div class="input-container">
                <input id="bike" class="radio-button" type="radio" name="radio" />
                <div class="radio-tile">
                    <div class="icon bike-icon">
                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M15.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM5 12c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.5c-1.9 0-3.5-1.6-3.5-3.5s1.6-3.5 3.5-3.5 3.5 1.6 3.5 3.5-1.6 3.5-3.5 3.5zm5.8-10l2.4-2.4.8.8c1.3 1.3 3 2.1 5.1 2.1V9c-1.5 0-2.7-.6-3.6-1.5l-1.9-1.9c-.5-.4-1-.6-1.6-.6s-1.1.2-1.4.6L7.8 8.4c-.4.4-.6.9-.6 1.4 0 .6.2 1.1.6 1.4L11 14v5h2v-6.2l-2.2-2.3zM19 12c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.5c-1.9 0-3.5-1.6-3.5-3.5s1.6-3.5 3.5-3.5 3.5 1.6 3.5 3.5-1.6 3.5-3.5 3.5z" />
                        </svg>
                    </div>
                    <label for="bike" class="radio-tile-label">Bike</label>
                </div>
            </div>

            <div class="input-container">
                <input id="drive" class="radio-button" type="radio" name="radio" />
                <div class="radio-tile">
                    <div class="icon car-icon">
                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                            <path d="M0 0h24v24H0z" fill="none" />
                        </svg>
                    </div>
                    <label for="drive" class="radio-tile-label">Drive</label>
                </div>
            </div>

            <div class="input-container">
                <input id="fly" class="radio-button" type="radio" name="radio" />
                <div class="radio-tile">
                    <div class="icon fly-icon">
                        <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.18 9" />
                            <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z" />
                            <path d="M0 0h24v24H0z" fill="none" />
                        </svg>
                    </div>
                    <label for="fly" class="radio-tile-label">Fly</label>
                </div>
            </div>
            <div class="input-container">
                <input id="walk" class="radio-button" type="radio" name="radio" />
                <div class="radio-tile">
                    <div class="icon walk-icon">
                        <!-- <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                        </svg> -->
            <!-- <i class="fas fa-walking fa-4x"></i>
    </div>
    <label for="walk" class="radio-tile-label">Walk</label>
    </div>
    </div>
    <div class="input-container">
        <input id="walk" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon walk-icon">
                <!-- <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                        </svg> -->
            <!-- <i class="fas fa-swimmer fa-4x"></i>
            </div>
            <label for="swim" class="radio-tile-label">swim</label>
        </div>
    </div> -->
            <!-- <div class="input-container">
        <input id="walk" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon walk-icon">
                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                </svg>
            </div>
            <label for="walk" class="radio-tile-label">Walk</label>
        </div>
    </div>
    <div class="input-container">
        <input id="walk" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon walk-icon">
                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                </svg>
            </div>
            <label for="walk" class="radio-tile-label">Walk</label>
        </div>
    </div>
    <div class="input-container">
        <input id="walk" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon walk-icon">
                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                </svg>
            </div>
            <label for="walk" class="radio-tile-label">Walk</label>
        </div>
    </div>
    <div class="input-container">
        <input id="walk" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon walk-icon">
                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7" />
                </svg>
            </div>
            <label for="walk" class="radio-tile-label">Walk</label>
        </div>
    </div>
    <div class="input-container">
        <input id="bike" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon bike-icon">
                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M15.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM5 12c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.5c-1.9 0-3.5-1.6-3.5-3.5s1.6-3.5 3.5-3.5 3.5 1.6 3.5 3.5-1.6 3.5-3.5 3.5zm5.8-10l2.4-2.4.8.8c1.3 1.3 3 2.1 5.1 2.1V9c-1.5 0-2.7-.6-3.6-1.5l-1.9-1.9c-.5-.4-1-.6-1.6-.6s-1.1.2-1.4.6L7.8 8.4c-.4.4-.6.9-.6 1.4 0 .6.2 1.1.6 1.4L11 14v5h2v-6.2l-2.2-2.3zM19 12c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.5c-1.9 0-3.5-1.6-3.5-3.5s1.6-3.5 3.5-3.5 3.5 1.6 3.5 3.5-1.6 3.5-3.5 3.5z" />
                </svg>
            </div>
            <label for="bike" class="radio-tile-label">Bike</label>
        </div>
    </div>
    <div class="input-container">
        <input id="bike" class="radio-button" type="radio" name="radio" />
        <div class="radio-tile">
            <div class="icon bike-icon">
                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M15.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM5 12c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.5c-1.9 0-3.5-1.6-3.5-3.5s1.6-3.5 3.5-3.5 3.5 1.6 3.5 3.5-1.6 3.5-3.5 3.5zm5.8-10l2.4-2.4.8.8c1.3 1.3 3 2.1 5.1 2.1V9c-1.5 0-2.7-.6-3.6-1.5l-1.9-1.9c-.5-.4-1-.6-1.6-.6s-1.1.2-1.4.6L7.8 8.4c-.4.4-.6.9-.6 1.4 0 .6.2 1.1.6 1.4L11 14v5h2v-6.2l-2.2-2.3zM19 12c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8.5c-1.9 0-3.5-1.6-3.5-3.5s1.6-3.5 3.5-3.5 3.5 1.6 3.5 3.5-1.6 3.5-3.5 3.5z" />
                </svg>
            </div>
            <label for="bike" class="radio-tile-label">Bike</label>
        </div>
    </div> -->


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

        //コメントが長くてもカードの高さをそろえる。本より。うまくいかず
        // $(function () {
        //     var column = 2,
        //         roop = Math.ceil($(".card .box").length / column),
        //         i;
        //     for (i = 0; i < roop; i++) {
        //         $(".js-heightLine-" + (i + 1)).heightLine();
        //     }
        // });
    </script>

</body>

</html>