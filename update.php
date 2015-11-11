<!--
・PHP内のコードを関数化できるものはしてコードをスリムにしたい
・ページの変更がうまくいかない。（前へ、次へ）
・delete（1件削除ができていない）
・updateまでたどり着いていない
-->


<?php
//1. 接続します
$pdo = new PDO('mysql:dbname=gs_db;host=localhost', 'root', '');

//2. DB文字コードを指定
$stmt = $pdo->query('SET NAMES utf8');


//３．データ登録SQL作成
//id基準で降順　１件毎の表示
$stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 1");

//４．SQL実行
$flag = $stmt->execute();

//データ表示
$view="";

//SQL実行チェック
if($flag==false){
    //エラーチェク
  $view = "SQLエラー1";
}else{
    //SQL実行OK!!
    
    //データベース上のデータをHTML上に出力
    //whileで回して設定件分出力
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
//表示するデータのid格納変数
$num = 0;
//もしname属性["sub1"]がクリックされたら実行
if (isset($_POST["sub1"])) {
    //クリックされたname属性["sub1"]のvaluewの値を$kbnに代入
    $kbn = htmlspecialchars($_POST["sub1"], ENT_QUOTES, "UTF-8");
    //$kbnの値により分岐
    switch ($kbn) {
        case '前へ':
            //降順なのでインクリメント
            ++$num;
            // $numの値チェック用echo
            echo $num;
        
            //データ登録SQL作成
            //id基準で降順　idが$numの値のデータを１件の表示
            $stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 1 OFFSET $num");

            //データ表示
            $view="";
            if($flag==false){
                //エラーチェク
                $view = "SQLエラー1";
            }else{
                //SQL実行OK!!
                while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    //データベース上のデータをHTML上に出力
                    //whileで回して設定件分出力
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
        
            //case 前へ終了
            break;
        
        case '次へ':
            //降順なのでデクリメント
            --$num;
            //表示許容範囲を超えないための処理
            if($num < 1){
                $num = 1;
            }
            //チェック用echo
            echo $num;
            //id基準で降順　idが$numの値のデータを１件の表示
            $stmt = $pdo->prepare("SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 1 OFFSET $num");
            //SQL実行
            $flag = $stmt->execute();

            //データ表示
            $view="";
            if($flag==false){
//            エラーチェック
                $view = "SQLエラー1-1";
            }else{
                //SQL実行OK!!
                while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
                //データベース上のデータをHTML上に出力
                //whileで回して設定件分出力
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
        
                //case 次へ終了
                break;
         
        //全件削除
        case '全削除':
            //caseに入っているかチェック用echo
            echo "全削除";
            $stmt = $pdo->query("DELETE FROM `gs_an_table`");
            //case 全件削除 終了
        break;
        
        //今閲覧しているデータ1件削除
        case '1件削除':
            //caseに入っているかチェック用echo
            echo "1件削除";
            //閲覧している１件削除
            
            $stmt =$pdo->prepare("DELETE FROM gs_an_table WHERE id = :id LIMIT 1");
            $result = $stmt->bindParam(':id',$id, PDO::PARAM_INT);
            $flag = $stmt->execute();
        
            break;
            
        //エラーチェック
        default:  echo "エラー"; exit;
        }
    }


if(!isset($_POST["post_flg"])){
  //echo "パラメータが無いので登録処理は無し";
}else{

  $name = $_POST["name"];
  $email = $_POST["email"];
  $age = $_POST["age"];
  $naiyou = $_POST["naiyou"];
  $indate = $_POST["indate"];


  //３．データ登録SQL作成
  $stmt = $pdo->prepare("INSERT INTO gs_an_table (name, email, age, naiyou)VALUES(:name, :email, :age, :naiyou)");
  $stmt->bindValue(':name', $name);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':age', $age);
  $stmt->bindValue(':naiyou', $naiyou);

    
  $status = $stmt->execute();   //sql実行
  if($status==false){
    echo "SQLエラー2-1";
    exit;
  }else{
      echo "<div class='container' style='background:#26f;'><p style='color:#f60;'>投稿完了<br>次のデータを入力してください。</p><a href='select.php'>結果はこちら！！</a></div>";
  }
}

?>




<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アップデート</title>
  <link href="css/reset.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
      ol>li{
          width: 350px;
          height: 50px;
          background-color: white;
          font-size:26px;
          position: relative;
          bottom: 230px;
          left: 460px;
          
      }
    #box1{
        background-color: aqua;
        height:100px;
        width:100px;
        position: relative;
        left:100px;
        top: 250px;
        
    }
    #box2{
        background-color: black;
        height:100px;
        width:100px;
          position: relative;
        left:140px;
        top: 100px;
    }
      #box3{
        background-color: orange;
        height:100px;
        width:100px;
          position: relative;
        left:154px;
        top: 74px;
    }
      #box4{
        background-color: greenyellow;
        height:100px;
        width:100px;
          position: relative;
        left:173px;
        top: -108px;
    }
      #box5{
        background-color: violet;
        height:100px;
        width:100px;
          position: relative;
        left:200px;
        top:-170px;
    }
      #title{
          color:coral;
          font-size: 70px;
          position: relative;
          left:310px;
          bottom:260px;
      }
      #main{
           position: relative;
          z-index: 2;
      }
    
    </style>
</head>
<body>
<div id="main">
<div class="container jumbotron">
<?=$view?>
<form method="POST" action="">
<input type="submit" value="前へ" name="sub1">
<input type="submit" value="次へ" name="sub1">
<input type="submit" value="全削除" name="sub1">
<input type="submit" value="1件削除" name="sub1">
</form>

</div>
 <div id="box1"></div>
 <div id="box2"></div>
 <div id="box3"></div>
 <div id="box4"></div>
 <div id="box5"></div>
 <h1 id="title">アンケート.com</h1>
  <div class="container">
        <div class="row">
<!--     フォーム-->
                  <div class="container" style="padding:20px 0">
                     <!--                   アンケート-->
                      <form class="form-inline" method="post" action="index.php" enctype="multipart/form-data" id="send_file">
                          <div class="form-group">
            <!--               Q1-->
                            <label class="contorol-label" for="name">１、名前</label>
                            <br>
                              <textarea type="text" id="name"  name="name" class="form-control" placeholder="name"></textarea>
                            <br>
            <!--                  Q2-->
                              <label class="contorol-label" for="email">２、メールアドレス</label>
                              <br>
                              <textarea type="text" id="email" name="email" class="form-control" placeholder="email"></textarea>
                                <br>
            <!--                  Q3-->
                              <label class="contorol-label" for="age">３、年齢</label>
                              <br>
                              <textarea type="text" id="age" name="age" class="form-control" placeholder="age"></textarea>
                                <br>
            <!--                  Q4-->
                              <label class="contorol-label" for="naiyou">コメント</label>
                              <br>
                              <textarea type="text" id="naiyou" name="naiyou" class="form-control" placeholder="naiyou"></textarea>
                                <br>
                                  <!--                 送信ボタン-->
                                  <input type="submit" value="送信" class="btn btn-primary btn-lg">
            <input type="hidden" name="post_flg" value="1">
                          </div>
                      </form>
                  </div>
            </div>
        </div>
</div>

</body>
</html>
