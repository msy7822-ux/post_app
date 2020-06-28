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

    // ユーザーが削除する予定の投稿の番号をまず受け取る
    $delete_num = $_POST['delete_num'];

    // ユーザーが入力した、各投稿のパスワードも受け取る
    $check_password = $_POST['check_password'];

    if($delete_num != NULL && $check_password != NULL){
        // 次にその番号の投稿がDB上に存在するか調べる
        $sql = 'SELECT * FROM tbpost WHERE id=:id ';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $delete_num, PDO::PARAM_INT);
        $statement->execute();

        $post = $statement->fetchAll(PDO::FETCH_NUM);
        // $postと単数けいにしたのは、idでwhereの条件を指定したから、どうせデータはひとつに定まるから

        $right_pass = "";
        foreach($post as $datas){
            $right_pass = $datas[count($datas) - 1];
        }

        if($post != [] && $check_password == $right_pass){
            $sql = ' DELETE FROM tbpost WHERE id=:id ';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':id', $delete_num, PDO::PARAM_INT);
            $statement->execute();

            echo("投稿の削除を行いました");
            echo("<br>");
            echo("<br>");

            // 投稿データの削除に成功したら、新しいデータの一覧を表示してあげる

            $sql = 'SELECT * FROM tbpost';
            $statement = $pdo->query($sql);
            $posts = $statement->fetchAll(PDO::FETCH_NUM);

            foreach($posts as $post_arr){
                for($i = 0; $i <= count($post_arr) -1 ; $i ++){
                    echo($post_arr[$i]);
                    echo("<br>");
                }
            }
    

        }elseif($post == []){
            echo("その番号の投稿データはありません");
        }elseif($check_password != $right_pass){
            echo("パスワードが異なります");
        }

    }elseif($delete_num == NUll){
        echo("削除する投稿番号が入力されていません");
    }elseif($check_password == NULL){
        echo("パスワードを入力してください");
    }

    


?>

<br>
<a href="mission5.html">入力ページに戻る</a>