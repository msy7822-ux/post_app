<?php
        // 変更追加の練習
    // 時刻設定をアジアの東京に設定
    date_default_timezone_set('Asia/Tokyo'); 

    // -----------------------------------------------------------

    // DB接続のためのプログラム

    ini_set('display_errors', 1);

    $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
    // mysql://b39312ac74998b:e9d47d33@us-cdbr-east-02.cleardb.com/heroku_7a80758e1ac8797?reconnect=true

    $db['dbname'] = ltrim($db['path'], '/');

    $dsn = "mysql:dbname={$db['dbname']};host={$db['host']};charset=utf8";

    $user = $db['user'];
    $password = $db['pass'];

    try{

        // インスタンスの生成
        $pdo = new PDO($dsn, $user, $password,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
        ));

    }catch(PDOException $e){
        echo "DB接続のエラー : ".$e->getMessage();
    }
    // 実行結果として、エラーメッセージは表示されなかったのでDB接続完了

    // ----------------------------------------------------------

?>

