<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>
	<?php 
		//接続オブジェクトを作成する
		$dsn = 'mysql:dbname=CampTest;host=localhost';
		$user = 'root';
		$password = 'camp2014';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql = 'select * from area_table order by id;';


		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		echo '<ul>';
		//無限ループ
		while(1){

			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($rec == false){
				//データの終わりにカーソルが移動した時無限ループを抜ける
				break;
			}

			$sql = 'select count(*) as `count` from friend_table where area_table_id='.$rec['id'].';';


			$stmt2 = $dbh->prepare($sql);
			$stmt2->execute();

			$rec_for_number = $stmt2->fetch(PDO::FETCH_ASSOC);

			echo '<li><a href="friends.php?id='.$rec['id'].'">'.$rec['name'].'('.$rec_for_number['count'].')'.'</a></li>';

		}

		echo '</ul>';

		$dbh = null;

	?>


</body>
</html>