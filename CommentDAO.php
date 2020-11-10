<?php
// 外部ファイルの読み込み
require_once 'Const.php';
require_once 'Message.php';
require_once 'Comment.php';

// データベースとやり取りを行う便利なクラス
class CommentDAO{
    
    // データベースと接続を行うメソッド
    private static function get_connection(){
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
          );
        $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD, $options);
        return $pdo;
    }
    
    // データベースとの切断を行うメソッド
    private static function close_connection($pdo, $stmp){
        $pdo = null;
        $stmp = null;
    }
    
    // 特定の投稿の全コメント情報を取得するメソッド
    public static function get_comments_by_message_id($message_id){
        $pdo = self::get_connection();
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE message_id=:message_id');
        // バインド処理
        $stmt->bindParam(':message_id', $message_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // フェッチの結果を、messageクラスのインスタンスにマッピングする
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Comment');
        $comments = $stmt->fetchAll();
        self::close_connection($pdo, $stmp);
        // メッセージクラスのインスタンスの配列を返す
        return $comments;
    }
    
    // データを1件登録するメソッド
    public static function insert($comment){
        $pdo = self::get_connection();
        $stmt = $pdo -> prepare("INSERT INTO comments (message_id, name, body) VALUES (:message_id, :name, :body)");
        // バインド処理
        $stmt->bindParam(':message_id', $comment->message_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $comment->name, PDO::PARAM_STR);
        $stmt->bindParam(':body', $comment->body, PDO::PARAM_STR);
        $stmt->execute();
        self::close_connection($pdo, $stmp);
    }
    
    
    // データを更新するメソッド
    public static function update($message){
        $pdo = self::get_connection();
        $image = self::get_image_name_by_id($message->id);
        $stmt = $pdo->prepare('UPDATE messages SET title=:title, body=:body, image=:image WHERE id = :id');
                        
        $stmt->bindParam(':title', $message->title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $message->body, PDO::PARAM_STR);
        $stmt->bindParam(':image', $message->image, PDO::PARAM_STR);
        $stmt->bindParam(':id', $message->id, PDO::PARAM_INT);
        
        $stmt->execute();
        self::close_connection($pdo, $stmp);
        
        // 画像の物理削除
        if($image !== $message->image){
            unlink(IMAGE_DIR . $image);
        }
    }
    
    // データを削除するメソッド
    public static function delete($id){
        $pdo = self::get_connection();
        $image = self::get_image_name_by_id($id);
        
        $stmt = $pdo->prepare('DELETE FROM messages WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        self::close_connection($pdo, $stmp);
        
        unlink(IMAGE_DIR . $image);

    }
    
    // ファイルをアップロードするメソッド
    public static function upload(){
        // ファイルを選択していれば
        if (!empty($_FILES['image']['name'])) {
            // ファイル名をユニーク化
            $image = uniqid(mt_rand(), true); 
            // アップロードされたファイルの拡張子を取得
            $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);

            $file = IMAGE_DIR . $image;

            // uploadディレクトリにファイル保存
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
            
            return $image;
        }else{
            return null;
        }
    }
}
