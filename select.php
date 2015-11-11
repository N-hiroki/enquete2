<!--
・ページの変更がうまくいかない。（前へ、次へ）
・リンクを貼りたいがまだたどり着いていない
・countを使用して件数を取得したい
-->


<?php
//1. 接続します
$pdo = new PDO('mysql:dbname=gs_db;host=localhost', 'root', '');

//2. DB文字コードを指定
$stmt = $pdo->query('SET NAMES utf8');

//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 5");


//４．SQL実行
$flag = $stmt->execute();

//データ表示
$view="";
$i = 0;
if($flag==false){
  $view = "SQLエラー";
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="container" style="padding:20px 0">
        <p>アンケートID:'.$result['id'].'</p><a href="">編集</a>
       <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr><th>Question</th><th>Answer</th></tr>
            </thead>
            <tbody><tr><td>date</td><td> ' . $result['indate'] . '</td></tr>' .'
        <tr><td>name</td><td> ' . $result['name'] . '</td></tr>' .
        '<tr><td>email</td><td> ' . $result['email'] . '</td></tr>' .
        '</tbody></table></div>';
    }
  }
   $num = 0;
if (isset($_POST["sub1"])) {
    $kbn = htmlspecialchars($_POST["sub1"], ENT_QUOTES, "UTF-8");
    switch ($kbn) {
        case "前へ":
        $num += 5;
        echo $num;
//        //データ数取得
//        $sql = 'SELECT COUNT(*) as cnt FROM gs_an_table';
//        $rs = mysql_query($sql);
//        $row = mysql_fetch_assoc($rs);
//        $count = $row['cnt'];
//        if($num > $count){
//            $num = $count;
//        }
        
        $stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 5 OFFSET $num");
        $flag = $stmt->execute();

            //データ表示
        $view="";
        $i = 0;
        if($flag==false){
    
        $view = "SQLエラー1";
        }else{
            while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $view .= '<div class="container" style="padding:20px 0">
            <p>アンケートID:'.$result['id'].'</p>
            <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr><th>Question</th><th>Answer</th></tr>
            </thead>
            <tbody><tr><td>name</td><td> ' . $result['name'] . '</td></tr>' .
            '<tr><td>email</td><td> ' . $result['email'] . '</td></tr>' .
            '<tr><td>age</td><td> ' . $result['age'] . '</td></tr>' .
            '<tr><td>naiyou</td><td> ' . $result['naiyou'] . '</td></tr>' .
            '<tr><td>date</td><td> ' . $result['indate'] . '</td></tr>' .
            '</tbody></table></div>';
            }
        }
        
        
        break;
        
        case "次へ":
        $num -= 5;
        if($num < 5){
            $num = 5;
        }
        echo $num;
            $stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 5 OFFSET $num");
            
            $flag = $stmt->execute();

            //データ表示
            $view="";
            $i = 0;
            if($flag==false){
    
            $view = "SQLエラー1-1";
            }else{
                while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $view .= '<div class="container" style="padding:20px 0">
            <p>アンケートID:'.$result['id'].'</p>
            <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr><th>Question</th><th>Answer</th></tr>
            </thead>
            <tbody><tr><td>name</td><td> ' . $result['name'] . '</td></tr>' .
            '<tr><td>email</td><td> ' . $result['email'] . '</td></tr>' .
            '<tr><td>age</td><td> ' . $result['age'] . '</td></tr>' .
            '<tr><td>naiyou</td><td> ' . $result['naiyou'] . '</td></tr>' .
            '<tr><td>date</td><td> ' . $result['indate'] . '</td></tr>' .
            '</tbody></table></div>';
                }
            }
        
        
        break;
        
        default:  echo "エラー"; exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>セレクト</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="main">
    <button class="btn btn-primary"><a href="index.php" style="color:white">トップ</a></button>
    <div class="container jumbotron">
    <?=$view?>
    <form method="POST" action="">
    <input type="submit" value="前へ" name="sub1">
    <input type="submit" value="次へ" name="sub1">
    </form>
   </div>
    
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
