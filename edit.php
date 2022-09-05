<?php
include "db.php";

	if (isset($_GET['id'])){
		$edit_id = $_GET['id'];
		$data = $dbh->prepare('SELECT * FROM users WHERE user_id = :q');
	    $data->execute(array('q' => $edit_id));
	    $row = $data->fetch(PDO::FETCH_ASSOC);

	    $edit_name = $row['name'];
	    $edit_mail = $row['email'];
	    $edit_phone = $row['phone'];

		if (isset($_POST['submit'])){
			$newname = $_POST['name'];
			$newmail = $_POST['email'];
			$newphone = $_POST['phone'];

			$data = $dbh->prepare('UPDATE users SET name = :name,email = :email,phone = :phone WHERE user_id = :edit_id');
    		$data->execute(array(':name' => $newname,':email' => $newmail,':phone' => $newphone,':edit_id' => $edit_id));
//сохраняем в куки уведомление об обновлении данных
	
	setcookie("update", $newname, time()+5);  // срок действия 5 секунд

    		
    		header('Location: /');
	}
		}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Система управления пользователями</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<p>Система управления пользователями</p><br>
	<a href='/'>На главную</a><br><br>

	Изменение данных пользователя:

	<form method="post">
		<label for="name">Имя:</label>
	    <input type="text" name="name" required value="<? echo $edit_name ?>"><br><br>

	    <label for="email">Email:</label>
	    <input type="email" name="email" required value="<? echo $edit_mail ?>"><br><br>

	    <label for="phone">Телефон:</label>
	    <input type="phone" name="phone" required value="<? echo $edit_phone ?>"><br><br>

	    <input type="submit" name="submit" value="Сохранить">
	</form>


	<?php
		if (isset($_POST['submit'])){
			$newname = $_POST['name'];
			$newmail = $_POST['email'];
			$newphone = $_POST['phone'];

			$data = $dbh->prepare('UPDATE users SET name = :name,email = :email,phone = :phone WHERE user_id = :edit_id');
    		$data->execute(array(':name' => $newname,':email' => $newmail,':phone' => $newphone,':edit_id' => $edit_id));

    		echo "<a href='/'>На главную</a><br><br>";
		}
	?>



</body>
</html>