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

    // DBのテーブルを作成するプログラムを作成

    $sql = 'CREATE TABLE IF NOT EXISTS tbpost (id INT AUTO_INCREMENT PRIMARY KEY, name CHAR(32), comment TEXT, created_at DATETIME);';

    $statement = $pdo->query($sql);

    // -----------------------------------------------------------

    $name = $_POST['name'];
    $comment = $_POST['comment'];
    // echo("{$name} {$comment}");
    // とりあえず、データを受け取って表示する段階はクリア
    $today = date('Y/n/j G:i:s');
    // 投稿した日時を記録する

    // 入力されたパスワードを受け取る
    $password = $_POST['password'];

    // -----------------------------------------------------------

    // データベースに、上記で受け取ったデータを追加する。

    if($name != NULL && $comment != NULL && $password != NULL){

        $sql = 'INSERT INTO tbpost (name, comment, created_at, password) VALUES (:name, :comment, :created_at, :password)';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $today);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
    
        $statement->execute();

        // データベースに保存が成功したら、その後今までの投稿と一緒に表示をする

        $sql = 'SELECT * FROM tbpost';
        $statement = $pdo->query($sql);
        $posts = $statement->fetchAll(PDO::FETCH_NUM);

        foreach($posts as $post_arr){
            for($i = 0; $i <= count($post_arr) -1 ; $i ++){
                echo($post_arr[$i]);
                echo("<br>");
            }
        }


    }elseif($name == NULL){
        echo("名前を入力してください");
    }elseif($comment == NULL){
        echo("コメントを入力してください");
    }elseif($password == NULL){
        echo("パスワードを設定してください");
    }

    // --------------------------------------------------------------


    

?>

<br>
<a href="mission5.html">入力ページに戻る</a>