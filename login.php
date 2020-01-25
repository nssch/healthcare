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

<body class="loginpage">
    <div>
        <h1>Title</h1>
        <img src="" alt="">
    </div>
    <div class="form">
        <form action="login_act.php" method="POST">
            <label for="lid">Login ID</label><br>
            <input type="text" placeholder="LoginID" name="lid"><br>

            <label for="lpw">Password</label><br>
            <input type="password" placeholder="Password" name="lpw"><br>

            <button>Login</button>
        </form>

        <div>
            <a href="register.php">新規登録</a>
        </div>
    </div>

</body>

</html>