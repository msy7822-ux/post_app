<?php
    require('dbconnect.php');

    // ----------------------------------------------------------

    // mission5_edit.phpの入力フォーム（編集用）からデータを受け取る
    $edit_name = $_POST['edit_name'];
    $edit_comment = $_POST['edit_comment'];
    // 編集する投稿の番号データ（id）も受け取る
    $edit_id = $_POST['edit_id'];

    if($edit_name != NULL && $edit_comment != NULL){
        $sql = 'UPDATE tbpost SET name=:name, comment=:comment WHERE id=:id ';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':name', $edit_name, PDO::PARAM_STR);
        $statement->bindParam(':comment', $edit_comment, PDO::PARAM_STR);
        $statement->bindParam(':id', $edit_id, PDO::PARAM_INT);

        $statement->execute();

        echo("投稿の編集を行いました");
        echo("<br>");
        echo("<br>");

        // 投稿データの編集に成功したら、一覧を表示してあげる

        $sql = 'SELECT * FROM tbpost';
        $statement = $pdo->query($sql);

        $datas = $statement->fetchAll(PDO::FETCH_NUM);

        foreach($datas as $arr){
            for($i = 0; $i <= count($arr) -1; $i++){
                echo($arr[$i]);
                echo("<br>");
            }
        }


    }elseif($edit_name == NULL){
        echo("名前を入力してください");

    }elseif($edit_comment == NULL){
        echo("コメントを入力してください");

    }


    
?>

<br>
<br>
<a href="mission5.html">入力ページに戻る</a>