	<?php 

		$area_id = $_GET['id'];

		if(isset($_GET['return'])){
			$return = $_GET['return'];
		}else{
			$return = 0;
		}

		//接続オブジェクトを作成する
		$dsn = 'mysql:dbname=CampTest;host=localhost';
		$user = 'root';
		$password = 'camp2014';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->query('SET NAMES utf8');

		$sql = 'select name from area_table where id='.$area_id.';';


		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

		$area_name = $rec['name'];

		$sql = 'select * from friend_table where area_table_id='.$area_id.';';

		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		//配列の初期設定
		//$friends =  array();

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

		
		$friends[] = $rec;

		while($rec){
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			
			$friends[] = $rec;
		}

		$dsn = null;
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title><?php echo $area_name.'フレンズ'; ?></title>
</head>
<body>
	<h4><?php echo $area_name.'フレンズ'; ?></h4>

	<?php if ($return == 1) {

		echo '友達が一人追加されました。<br />';

	}

	//TODO:性別0人の場合は0人と表示する処理を追加
	?>
	<ul>
		<?php 

		foreach ($friends as $friend_each) {
			$button_tag = '<form method="POST" action="edit.php?friend_id='.$friend_each['id'].'"><input type="submit" value="編集" /></form>';
			echo '<li>'.$friend_each['name'].$button_tag.'</li>';
		}
		?>
	</ul>
	<form method="POST" action="add.php?id=<?php echo $area_id; ?>">
		<input type="hidden" name="area_table_id" value="<?php echo $area_id; ?>" >
		<input type="submit" value="追加">
	</form>
</body>
</html>