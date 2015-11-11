<?php
if(!isset($_POST["post_flg"])){
  //echo "パラメータが無いので登録処理は無し";
}else{
//  $id = $_POST["id"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $age = $_POST["age"];
  $naiyou = $_POST["naiyou"];
  $indate = date("Y-m-d H:i:s");
    

  //1. 接続します
  $pdo = new PDO('mysql:dbname=gs_db;host=localhost', 'root', '');

  //2. DB文字コードを指定
  $stmt = $pdo->query('SET NAMES utf8');

  //３．データ登録SQL作成
  $stmt = $pdo->prepare("INSERT INTO gs_an_table (name, email, age, naiyou, indate)VALUES(:name, :email, :age, :naiyou, :indate)");
  $stmt->bindValue(':name', $name);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':age', $age);
  $stmt->bindValue(':naiyou', $naiyou);
  $stmt->bindValue(':indate', $indate);
    
  $status = $stmt->execute();   //sql実行
  if($status==false){
    echo "SQLエラー";
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
  <title>インデックス</title>
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
