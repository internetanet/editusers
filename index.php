<?php
include "db.php";

//Удаление пользователя
	if (isset($_GET['delete'])){
		$delete_id = $_GET['delete'];

		$data = $dbh->prepare('SELECT name FROM users WHERE user_id = :delete_id');
	    $data->execute(array('delete_id' => $delete_id));
	    $row = $data->fetch(PDO::FETCH_ASSOC);
	    $delete_name = $row['name'];

		$data = $dbh->prepare('DELETE FROM users WHERE user_id = :user_id');
	    $data->bindParam(':user_id', $delete_id);
	    $data->execute();
//сохраняем в куки уведомление об удалении
setcookie("delete", $delete_name, time()+5);  // срок действия 5 секунд

	    header('Location: /');
	    exit();
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
<?php
	if (isset($_COOKIE['update'])) echo "<span>Данные пользователя " . $_COOKIE["update"]. " обновлены.</span><br>";
	if (isset($_COOKIE['delete'])) echo "<span>Пользователь " . $_COOKIE["delete"]. " удален из базы данных.</span><br>";
	if (isset($_COOKIE['add'])) echo "<span>Добавлен новый пользователь " . $_COOKIE["add"].".</span><br>";
?>
<a href='add.php'>Добавить нового пользователя</a><br><br>

<?php

//Вывод пользователей в таблице
$data = $dbh->prepare('SELECT `user_id` FROM `users` ORDER BY `user_id` DESC LIMIT 1');
$data->execute(array('q' => $q));
$row = $data->fetch(PDO::FETCH_ASSOC);
$last_id = $row['user_id'];

	$q = 1;
	echo "<table><tr><th>id</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Дата регистрации</th><th>Действия</th>";
	while($q <= $last_id) {
	 	$data = $dbh->prepare('SELECT * FROM users WHERE user_id = :q');
	    $data->execute(array('q' => $q));
	    $row = $data->fetch(PDO::FETCH_ASSOC);
	    if(!empty($row['user_id'])){
		    echo "<tr><td>".($row['user_id'])."</td><td>".($row['name'])."</td><td>".($row['email'])."</td><td>".($row['phone'])."</td><td>".($row['reg_date'])."</td><td><a href='edit.php?id=".($row['user_id'])."'>Изменить|</a><a href='index.php?delete=".($row['user_id'])."'>Удалить</a></td></tr>";
		    $q++;
		}else{
			$q++;
		}
	}

?>




</body>
</html>