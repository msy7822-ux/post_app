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