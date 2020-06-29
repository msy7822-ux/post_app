<?php

    require('dbconnect.php');
    // ----------------------------------------------------------


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