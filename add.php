<?php
include "db.php";

	if (isset($_POST['submit'])){
		$new_name = $_POST['name'];
		$new_email = $_POST['email'];
		$new_phone = $_POST['phone'];
		$now_date = date('Y-m-d');
		$count_user = $dbh->query('SELECT COUNT(*) as count FROM users')->fetchColumn();
		$u_number = $count_user+1;

		$STH = $dbh->prepare("INSERT INTO users (u_number,name,email,phone,reg_date)values(:u_number,:name,:email,:phone,:reg_date)");
		$STH->bindParam(':u_number',$u_number);
		$STH->bindParam(':name',$new_name);
		$STH->bindParam(':email',$new_email);
		$STH->bindParam(':phone',$new_phone);
		$STH->bindParam(':reg_date',$now_date);
		$STH->execute();

		//сохраняем в куки уведомление
		setcookie("add", $new_name, time()+5);  // срок действия 5 секунд
		header('Location: /');
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

	Данные нового пользователя:

	<form method="post">
		<label for="name">Имя:</label>
	    <input type="text" name="name" required><br><br>

	    <label for="email">Email:</label>
	    <input type="email" name="email" required><br><br>

	    <label for="phone">Телефон:</label>
	    <input type="phone" name="phone" required><br><br>

	    <input type="submit" name="submit" value="Добавить">
	</form>



</body>
</html>