<?php

    // controller
    
    // 外部ファイルの読み込み
    require_once 'CommentDAO.php';
    
    // セッション開始
    session_start();

    // POST通信ならば（= 新規投稿ボタンが押された時）
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // フォームからの入力値を取得
        $message_id = $_POST['message_id'];
        $name = $_POST['name'];
        $body = $_POST['body'];

        // 例外処理
        try {

            // 新しいメッセージインスタンスを生成
            $comment = new Comment((int)$message_id, $name, $body);

            // データベースにデータを1件保存
            CommentDAO::insert($comment);
            
            // セッションにフラッシュメッセージを保存        
            $_SESSION['flash_message'] = "コメント投稿が成功しました。";
            
            // 画面遷移
            header('Location: show.php?id=' . $message_id);
            exit;
            
        } catch (PDOException $e) {
            echo 'PDO exception: ' . $e->getMessage();
            exit;
        }
    }else{
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = '不正アクセスです';
        
        // 画面遷移
        header('Location: index.php');
        exit;
    }
    