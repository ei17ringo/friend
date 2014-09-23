	<?php 

		$area_id = $_GET['id'];


		//接続オブジェクト
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

		if (isset($_POST['name'])){
			//保存ボタンが押された時
			$name = $_POST['name'];
			$gender = $_POST['gender'];
			$age = $_POST['age'];
			$area_table_id = $_POST['area_table_id'];

			$sql = 'INSERT INTO `friend_table` (area_table_id,name,age,gender)';
			$sql .= 'values("'.$area_table_id.'","'.$name.'","'.$age.'","'.$gender.'");';


	
			$stmt = $dbh->prepare($sql);
			$stmt->execute();

			$dsn = null;
			header('location:friends.php?id='.$area_table_id.'&return=1');
			exit();


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

	<form method="POST" action="add.php?id=<?php echo $area_id; ?>">
		名前:<input type="text" name="name" style="width:150px;"><br />
		年齢:<input type="text" name="age" style="width:150px;"><br />
		性別:<select name="gender">
				<option value="男">男性</option>
				<option value="女">女性</option>
			</select>
			<input type="hidden" name="area_table_id" value="<?php echo $area_id; ?>" >
		<br />
		<input type="submit" value="保存">
	</form>
</body>
</html>