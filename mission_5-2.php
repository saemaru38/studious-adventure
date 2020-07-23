<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_5-2</title>
    </head>
    
    <?php
    
        $name1 = $_POST["name1"];
        $str = $_POST["str"];
        $num = $_POST["num"];
        $edit_num = $_POST["edit_num"];
        $clear_num = $_POST["clear_num"];
        $hidden_num = $_POST["hidden_num"];
        
        //データベースに接続する
        $dsn = 'データベース名';
	    $user = 'ユーザ名';
	    $password = 'パスワード';
    	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	    //echo "接続できました"."<br>";
	    
	    //CREATEコマンドを使ってデータベースにテーブルを作成する
        $sql = "CREATE TABLE IF NOT EXISTS tbtest5_2" //tbtestというテーブルを作成
        ."("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT"
        . ");";
        $stmt = $pdo->query($sql);
        //echo "テーブルが作成されました"."<br>";
        
        //テーブルの削除
        /*$sql = 'DROP TABLE tbtest5_1';
		$stmt = $pdo->query($sql);
		echo "テーブルtbtest5_1を消去しました";
		*/
        
        //テーブル一覧を表示する
        $sql ='SHOW TABLES';
    	$result = $pdo->query($sql);
	    foreach ($result as $row){
    		echo $row[0];
		    echo '<br>';
	    }
	    echo "<hr>";
	    
	    //テーブルの中身を確認する
        /*$sql = 'SHOW CREATE TABLE tbtest';
        $result = $pdo->query($sql);
        foreach($result as $row){
            echo $row[1];
        }
        echo "<hr>";*/
        
        if(!empty($num)&&isset($num)){ //削除番号が入力されたら
            $id = $num;
            $sql = 'delete from tbtest5_2 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            //echo $id."<br>";
        }

        
        else if(!empty($edit_num)&&isset($edit_num)){
            $sql = 'SELECT * FROM tbtest5_2';
    	    $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
    	    foreach ($results as $row){
		        if($row['id'] == $edit_num){
		            $edit_name = $row['name'];
		            $edit_str = $row['comment'];
		        }

        	}
        }
        
        else if(!empty($hidden_num)&&isset($hidden_num)){ //編集番号が入力されたら
            $id = $hidden_num;
            $name = $name1;
            $comment = $str;
            $sql = 'UPDATE tbtest5_2 SET name=:name,comment=:comment WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name',$name,PDO::PARAM_STR);
            $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
        }

        else if(!empty($name1)&&!empty($str)){
    	    //作成したテーブルにINSERTを使ってデータを入力する
            $sql = $pdo -> prepare("INSERT INTO tbtest5_2 (name, comment) VALUES (:name, :comment)");
	        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        	$name = $name1;
	        $comment = $str; //好きな名前、好きな言葉は自分で決めること
	        $sql -> execute();
    	}
    ?>
    
    <body>
        <form action = "" method = "post">
            <input type = "text" name = "name1" placeholder = "名字 名前" 
            value = 
            "<?php if(!empty($_POST['edit_num'])) { echo $edit_name; } ?>"
            ><br>
            <input type = "text" name = "str" placeholder = "コメント入力"
            value = 
            "<?php if(!empty($_POST['edit_num'])) { echo $edit_str; } ?>"
            ><br>
            <input type = "hidden" name = "hidden_num"
            value = 
            "<?php if(!empty($_POST['edit_num'])) { echo $_POST['edit_num']; } ?>"
            >
            <input type = "submit" name = "sbmit"><br><br>
            <input type = "text" name = "num" placeholder = "削除対象番号">
            <input type = "submit" name = "clear" value = "削除"><br><br>
            <input type = "text" name = "edit_num" placeholder = "編集対象番号">
            <input type = "submit" name = "edit" value = "編集">
        </form>
    </body>
    
    <?php
	    //入力したデータをselectによって表示
        $sql = 'SELECT * FROM tbtest5_2';
    	$stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
    	foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
	    	echo $row['id'].',';
    		echo $row['name'].',';
		    echo $row['comment'].'<br>';
	        echo "<hr>";
    	}
        
    ?>
</html>