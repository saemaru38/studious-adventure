<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_3-5</title>
    </head>
    <?php
        $name = $_POST["name"];
        $str = $_POST["str"];
        $hidden_num = $_POST["hidden_num"];
        $password_1 = $_POST["password_1"];
        $clear_num = $_POST["clear_num"];
        $password_2 = $_POST["password_2"];
        $edit_num = $_POST["edit_num"];
        $password_3 = $_POST["password_3"];
        $date = date('Y年m月d日 h時i分s秒');
        $pass = "pass";//正しいパスワード
        $filename = "mission_3-5.txt";
        
        //投稿番号について
        if(!file_exists($filename)){
           $count = 1; 
        } else {
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $i = count(file($filename));
            $word = explode("<>",$lines[$i-1]);
            $count = $word[0] + 1;
        }

        //削除について
        if(!empty($clear_num)&&isset($clear_num)){
            if(!empty($password_2)&&isset($password_2)){
                if($password_2 == $pass){//正しいパスワードが入力されたら
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    $fp = fopen($filename,"w");
                    for($i = 0; $i < count($lines); $i++){
                        $word_2 = explode("<>",$lines[$i]);
                        if($clear_num != $word_2[0]){
                            fwrite($fp,$lines[$i].PHP_EOL);
                        }
                    }
                } else {
                    echo "パスワードが正しくありません"."<br>";
                }
            } else {
                echo "パスワードを入力してください"."<br>";
            }
        } else if(!empty($edit_num)){ //編集について
            if(!empty($password_3)&&isset($password_2)){
                if($password_3 == $pass){
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    $fp = fopen($filename,"w");
                    for($i = 0; $i < count($lines); $i++){
                        $word_3 = explode("<>",$lines[$i]);
                        fwrite($fp,$lines[$i].PHP_EOL);
                        if($edit_num == $word_3[0]){
                            $edit_name = $word_3[1];
                            $edit_str = $word_3[2];
                        }
                    }
                } else {
                    echo "パスワードが正しくありません"."<br>";
                }
            } else {
                echo "パスワードを入力してください"."<br>";
            }
        } else if(!empty($str)&&empty($name)){
            echo "名前を入力してください";
        } else if(!empty($name)&&isset($name)){
            if(empty($str)){
                echo "コメントを入力してください";
            } else {
                if(!empty($password_1)&&isset($password_1)){
                    if($password_1 == $pass){
                        if(!empty($hidden_num)){
                            $lines = file($filename,FILE_IGNORE_NEW_LINES);
                            $fp = fopen($filename,"w");
                            for($i = 0; $i < count($lines); $i++){
                                $word_4 = explode("<>",$lines[$i]);
                                if($hidden_num != $word_4[0]){
                                    fwrite($fp,$lines[$i].PHP_EOL);
                                } else {
                                    fwrite($fp,$hidden_num."<>".$name."<>".$str."<>".$date.PHP_EOL);
                                }
                            }
                        } else {
                            $fp = fopen($filename,"a");
                            fwrite($fp,$count."<>".$name."<>".$str."<>".$date.PHP_EOL);
                        }
                    } else {
                        echo "パスワードが正しくありません"."<br>";
                    }
                } else {
                    echo "パスワードを入力してください"."<br>";
                }
            }
        }
    ?>
    <body>
        <form action = "" method = "post">
            <input type = "text" name = "name" placeholder = "名前"
            value = "<?php if(!empty($edit_num)){ echo $edit_name; }?>"
            ><br>
            <input type = "text" name = "str" placeholder = "コメント"
            value = "<?php if(!empty($edit_num)){ echo $edit_str; }?>"
            ><br>
            <input type = "text" name = "password_1" placeholder = "パスワード"><br>
            <input type = "hidden" name = "hidden_num"
    ;       value = "<?php if(!empty($edit_num)){ echo $edit_num; }?>"
            >
            <input type = "submit" name = "submit"><br><br>
            <input type = "text" name = "clear_num" placeholder = "削除番号"><br>
            <input type = "text" name = "password_2" placeholder = "パスワード"><br>
            <input type = "submit" name = "clear" value = "削除"><br><br>
            <input type = "text" name = "edit_num" placeholder = "編集番号"><br>
            <input type = "text" name = "password_3" placeholder = "パスワード"><br>
            <input type = "submit" name = "edit" value = "編集"><br>
        </form>
    </body>
    
    <?php
        if(file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $line2 = explode("<>",$line);
                for($i = 0; $i < 4; $i = $i + 1){
                    echo $line2[$i]." ";
                }
                echo "<br>";
            }
        }
    ?>
    
</html>