<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="shortcut icon" href="favicon.ico">

        <title>投稿詳細</title>
        <style>
            h2{
                color: red;
                background-color: pink;
            }
            img{
                width: 60%;
            }
            .comments{
                border: solid 2px #8080806b;
                border-radius: 60px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row mt-2">
                <h1 class="text-center col-sm-12">id: <?= $message_id ?> の投稿詳細</h1>
            </div>
            <div class="row mt-2">
                <h2 class="text-center col-sm-12"><?= $flash_message ?></h1>
            </div>
            <div class="row mt-2">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>id</th>
                        <td><?= $message->id ?></td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td><?= $message->name ?></td>
                    </tr>
                    <tr>
                        <th>タイトル</th>
                        <td><?= $message->title ?></td>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <td><?= $message->body ?></td>
                    </tr>
                    <tr>
                        <th>画像</th>
                        <td><img src="<?= IMAGE_DIR . $message->image ?>" alt="表示する画像がありません。"></td>
                    </tr>
                </table>
            </div> 
            
            <div class="row mb-5">
                <a href="edit.php?id=<?= $message_id ?>" class="col-sm-6 btn btn-primary">編集</a>
                <form class="col-sm-6" action="delete.php" method="POST">
                    <input type="hidden" name="id" value="<?= $message_id ?>">
                    <button type="submit" class="btn btn-danger col-sm-12" onclick="return confirm('投稿を削除します。よろしいですか？')">削除</button>
                </form>
            </div>   
            <div class="offset-sm-2 col-sm-8 comments">
                <!-- 1行 -->
                <div class="row">
                    <h3 class="offset-sm-3 col-sm-6 text-center mt-3 mb-3">コメント一覧</h3>
                </div>
                <?php if(count($comments) !== 0){ ?>
                <div class="row">
                    <p class="offset-sm-1 col-sm-1"><?= count($comments) ?>件</p>
                </div>
                <div class="row">
                    
                    <table class="offset-sm-1 col-sm-10 table table-bordered table-striped">
                        <tr>
                            <th>コメントID</th>
                            <th>名前</th>
                            <th>コメント</th>
                            <th>コメント時刻</th>
                        </tr>   
                        <?php foreach($comments as $comment){ ?>
                        <tr>
                            <td><?= $comment->id ?></td>
                            <td><?= $comment->name ?></td>
                            <td><?= $comment->body ?></td>
                            <td><?= $comment->created_at ?></td>
                        </tr>     
                        <?php } ?>
                    </table>
                <?php }else{ ?>
                    <p class="offset-sm-1 col-sm-10 text-center">コメントはまだありません</p>
                <?php } ?>
                </div>
                <div class="row mt-3">
                    <form action="comment_create.php" method="POST" class="form-group offset-sm-1 col-sm-10">
                        <input type="hidden" name="message_id" value="<?= $message_id ?>">
                        <!-- 1行 -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">名前</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                    
                        <!-- 1行 -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">コメント</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="body" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="offset-2 col-10">
                                <button type="submit" class="btn btn-primary">コメント</button>
                            </div>
                        </div>
                    </form>
    
                </div>
            </div>
            
                
            <div class="row mt-5 mb-3">
                <a href="index.php" class="col-sm-12 btn btn-primary">投稿一覧</a>
            </div>
        </div>
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS, then Font Awesome -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script>
            function previewImage(obj)
            {
            	var fileReader = new FileReader();
            	fileReader.onload = (function() {
            		document.getElementById('preview').src = fileReader.result;
            	});
            	fileReader.readAsDataURL(obj.files[0]);
            }
        </script>
    </body>
</html>