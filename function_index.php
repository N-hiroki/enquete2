<?php

function a(){
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
  ?>