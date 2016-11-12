<!DOCTYPE html>
<html>
<head>
	<title>Обработка форм</title>
	<style>
		form {
			margin: 0 auto;
			width: 350px;
		}
	</style>
</head>
<body>

<h3 align="center">Загрузка тестовых файлов на сервер (расширение *.json)</h3>

<form action="list.php" enctype="multipart/form-data" method="post">
	<input type="file" name="testfile" />
	<button type="submit">Загрузить</button>
</form>


</body>
</html>