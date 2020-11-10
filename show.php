<?php

    // controller
    
    // 外部ファイルの読み込み
    require_once 'MessageDAO.php';
    require_once 'CommentDAO.php';
    
    // セッション開始
    session_start();
    
    // 注目している投稿のID
    $message_id = "";
    
    // 注目している投稿
    $message = "";
    
    // 注目している投稿に関するコメント一覧
    $comments = "";

    // フラッシュメッセージを保存する変数
    $flash_message = "";
    
    // セッションからフラッシュメッセージの取得、削除
    if(isset($_SESSION['flash_message']) === true){
        $flash_message = $_SESSION['flash_message'];
        $_SESSION['flash_message'] = null;
    }

    // 注目している投稿のIDを取得
    if(isset($_GET['id']) === true){
        $message_id = $_GET['id'];
    }else{
        // 画面遷移
        header('Location: index.php');
        exit;
    }
    
    // 例外処理
    try {
        
        // 注目してるメッセージインスタンスを取得
        $message = MessageDAO::get_message_by_id($message_id);
        $comments = CommentDAO::get_comments_by_message_id($message_id);
        
        // view のインクルード
        include_once 'show_view.php';
    
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }
