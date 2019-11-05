<?php

$db_host = "localhost";
$db_name = "board_db";
$db_user = "board_user";
$db_pass = "board_pass";

// データベースへ接続
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if($link !== false){
    $msg = "";
    $err_msg = "";

    if(isset($_POST["send"]) === true){
        $name = $_POST["name"];
        $comment = $_POST["comment"];

        if($name !== "" && $comment !== ""){
            $query = " INSERT INTO board ("
                . " name , "
                . "comment "
                . ") VALUES ("
                . " '" . mysqli_real_escape_string($link, $name)."', "
                . " '" . mysqli_real_escape_string($link, $comment) . "'"
                . ")";
            $res = mysqli_query($link, $query);
            if($res !== false){
                $msg = "書き込みに成功しました";
            }
            else{
                $msg = "書き込みに失敗しました";
            }
        }
        else{
            $err_msg = "名前とコメントを記入してください";
        }
    }

    $query = "SELECT id, name, comment FROM board";
    $res = mysqli_query($link, $query);
    $data = array();
    while($row = mysqli_fetch_assoc($res)){
        array_push($data, $row);
    }
    arsort($data);
}
else{
    echo "データベースの接続に失敗しました";
}

// データベースへの接続を閉じる
mysqli_close($link);
?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Bootstrap</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <form method="post" action="" class="form-horizontal">
            <!-- <form class="form-horizontal"> -->
            <div class="form-group">
                <label for="inputnName" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputComment" class="col-sm-2 control-label">Comment</label>
                <div class="col-sm-10">
                    <textarea name="comment" class="form-control" id="inputComment"></textarea><br><br>
                </div>
            </div>
            <!-- </form> -->
            <!-- 名前：<input type="text" name="name" value="" /><br><br> -->
            <!-- コメント：<textarea name="comment" cols="20" rows="4"></textarea><br> -->
            <!-- <input type="submit" name="send" value="click"> -->
            <button type="submit" class="btn btn-primary" name="send">Submit</button><br><br>
        </form>
        <!-- 書き込まれたデータを表示 -->


<?php
    // echo "<p>" . $send . "</p>";
    // echo "<p>" . $name . "</p>";
    // echo "<p>" . $comment . "</p>";
    if($msg !== "") echo "<p>" . $msg . "</p>";
    if($err_msg !== "") echo '<p style="color:#f00;">' . $err_msg . '</p>';
?>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    foreach($data as $key => $val){
        // echo $val["name"] . "：" . $val["comment"] . "<br>";
        echo "<tr>";
        echo '<th scope="row">';
        echo $key ;
        echo "</th>";
        echo "<td>";
        echo $val["name"];
        echo "</td>";
        echo "<td>";
        echo $val["comment"];
        echo "</td>";
        echo "</tr>";
    }
?>
                </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
