<?php
mb_internal_encoding("UTF-8");
error_reporting();

	try {
		$dbh = new PDO('mysql:dbname=mydb;host=localhost', 'root', '');

	} catch (PDOException $e) {
		die('Подключение не удалось: ' . $e->getMessage());
	}
?>