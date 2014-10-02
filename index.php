<?php 
		$count = 0; //初期化

		//接続オブジェクトを作成する
		$dsn = 'mysql:dbname=CampTest;host=localhost';
		$user = 'root';
		$password = 'camp2014';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql = 'select * from area_table order by id;';


		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		/* 

		echo '<ul>';
		無限ループ
		
		*/
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

			$rec['name'] = $rec['name'].'('.$rec_for_number['count'].')';
			$area[] = $rec;

			//echo '<li><a href="friends.php?id='.$rec['id'].'">'.$rec['name'].'('.$rec_for_number['count'].')'.'</a></li>';

		}

		//echo '</ul>';

		if (isset($_POST['search']) == true){
			//検索ボタンが押されました
			$search_sql = 'select * from friend_table where name like \'%'.$_POST['search'].'%\'';

			$stmt3 = $dbh->prepare($search_sql);
			$stmt3->execute();

			$count = 0;  //検索に一致したフレンドカウンター
			while(1){

				$rec = $stmt3->fetch(PDO::FETCH_ASSOC);

				if ($rec == false){
					//データの終わりにカーソルが移動した時無限ループを抜ける
					break;
				}

				$friend[] = $rec;

				$count++;
			}

			var_dump($count);

		}

		$dbh = null;


		$var1 = 'はい';
		$var2 = 'いいえ';

		$var_name = 'var2';

		echo $$var_name;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ひとこと掲示板</title>

     <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
<title>PHP基礎</title>
</head>
<body>
	<form method="POST" action="index.php">
		<input name="search" type="text" style="width:100px;">
		<input type="submit" value="検索">
	</form>
	<?php 
		if ($count == 0) {
			echo '検索結果がありません。';
		}else{
			if ($count == 1){
				//その人のページにリダイレクト
				//var_dump($friend);
				header('location:edit.php?friend_id='.$friend[0]['id']);
			}else{
				//友達リストを表示
				echo '<ul>';
				foreach ($friend as $friend_each) {
					echo '<li><a href="edit.php?friend_id='.$friend_each['id'].'">'.$friend_each['name'].'</a></li>';
				}
				echo '</ul>';

			}

		}

	?>

	<div class="col-sm-3">
		<ul class="list-group">
			<?php foreach ($area as $area_each) {
				echo '<li class="list-group-item"><a href="friends.php?id='.$area_each['id'].'">'.$area_each['name'].'</a></li>';
			}?>
		</ul>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>