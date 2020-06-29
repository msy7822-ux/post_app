<?php

    require('dbconnect.php');

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