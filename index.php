<?php
        // 時刻設定をアジアの東京に設定
        date_default_timezone_set('Asia/Tokyo'); 

        // -----------------------------------------------------------
    
        // DB接続のためのプログラム
    
        ini_set('display_errors', 1);
    
        $dsn = 'mysql:dbname=tb220104db;host=localhost;charset=utf8';
        $user = 'tb-220104';
        $password = 'TEywzDmNne';
    
        try{
    
            // インスタンスの生成
            $pdo = new PDO($dsn, $user, $password,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::ATTR_EMULATE_PREPARES => false,
            ));
    
        }catch(PDOException $e){
            echo "DB接続のエラー : ".$e->getMessage();
        }
        // 実行結果として、エラーメッセージは表示されなかったのでDB接続完了
    
        // ----------------------------------------------------------

        // これまでの投稿の一覧を表示するためのプログラムを記述

        $sql = 'SELECT * FROM tbpost';
        $statement = $pdo->query($sql);
        $posts = $statement->fetchAll(PDO::FETCH_NUM);

        foreach($posts as $post_arr){
            for($i = 0; $i <= count($post_arr) -1 ; $i ++){
                echo($post_arr[$i]);
                echo("<br>");
            }
        }    
?>

<br>
<a href="mission5.html">入力ページへ</a>