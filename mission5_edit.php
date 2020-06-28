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

    // ユーザーが編集する予定の投稿データの投稿番号を取得
    $edit_num = $_POST['edit_num'];

    // ユーザーが入力したパスワードを受け取る
    $check_password = $_POST['check_password'];


    if($edit_num != NULL && $check_password != NULL){
        // 次にその編集予定の番号の投稿データが存在するか調べる
        $sql = 'SELECT * FROM tbpost WHERE id=:id';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $edit_num, PDO::PARAM_INT);
        $statement->execute();

        $post = $statement->fetchAll(PDO::FETCH_NUM);

        $name = "";
        $comment = "";
        $id = 0;

        $right_pass = "";

        foreach($post as $datas){
            $right_pass = $datas[count($datas) - 1];
        }

        $bool = true;
        // falseだったら、ボタンを非表示にする。

        if($post != [] && $check_password == $right_pass){
            foreach($post as $data){
                $id = $data[0];
                $name = $data[1];
                $comment = $data[2];
                echo("<br>");
            }
        }elseif($post == []){
            echo("その番号の投稿データはありません");
            echo("<br>");
            $bool = false;
            
        }elseif($check_password != $right_pass){
            echo("パスワードが異なっています");
            echo("<br>");
            $bool = false;

        }
    }elseif($edit_num == NULL){
        echo("削除する投稿番号を入力されていません");
        echo("<br>");

        $bool = false;
    }elseif($check_password == NULL){
        echo("パスワードが入力されていません");
        echo("<br>");

        $bool = false;
    }

    
?>

<?php if($bool): ?>

<form action="mission5_edit_do.php" method="post">
    <input type="hidden" name="edit_id" value="<?php echo($id); ?>">
    <input type="text" name="edit_name" value="<?php echo($name); ?>">

    <br>
    <br>

    <textarea name="edit_comment"><?php echo($comment); ?></textarea>

    <br>
    <br>

    <input type="submit" value="変更">
</form>

<?php endif; ?>
