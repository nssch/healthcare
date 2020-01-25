<?php
//セッションスタート
session_start();

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
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
</head>

<body>
    <div class="carousel-ui">
        <div>
            <img src="img/4438.jpg">
            <p class="detail">Ｅｘ(エクササイズ)とは身体活動の量のこと。<br>
                活動強度×時間でもとめます<br>
                １Ｅｘの活動であなたの体重×1.05kcal消費できます</p>
        </div>

        <div>
            <img src="img/25112.jpg">
            <p class="detail">例えば80kgの方が毎日１Ｅｘ継続すると・・・<br>
                80×1.05=84kcal/日 消費できます。<br>
                約90日継続すると約7500kcal消費！<br>
                これは脂肪約１kg燃焼するのに必要なエネルギーに相当します</p>
        </div>
        <div>
            <img src="img/10249.jpg">
            <p class="detail">忙しい毎日に取り入れられそうな１Ｅｘの活動を継続することからスタート</p>
        </div>
        <div>
            <img src="img/60545.jpg">
            <p class="detail">Exをどんどんプラスしてレベルアップ・ランキング入りを目指しましょう<br>
                <br>
                まずは現在の体重を入力してください</p>
            <div class="form" style="background-color: white;">
                <form action="start_insert.php" method="POST">
                    <label for="weight">現在の体重</label><br>
                    <input type="number" name="weight" id="weight"><br>
                    <button type="submit">次へ</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="slick.min.js"></script>
    <script>
        $(function() {
            $('.carousel-ui').slick({
                infinite: false,
                arrows: true,
                dots: true,
                adaptiveHeight: true,

            });

        });
    </script>
</body>

</html>