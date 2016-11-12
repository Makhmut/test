<?php require_once "func.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Тесты</title>
	<style>
		table {
			margin: 0 auto;
			width: 320px;
		}
	</style>
</head>
<body>

<?php

$dir = scandir('tests');

// Если папка с тестовым файлом пуста(вернее меньше трех, потому что у скандира есть по умолчанию два элемента), 
// то загружаем файлы на сервер
if(count($dir) < 3) {
	echo '<h3 align="center">В папке нет файлы для тестирование, загрузите файл по ссылку:</h3>';
	echo '<a href="admin.php" style="text-align: center; display: block">Загрузить тестовых файлов на сервер</a>';
}
// Иначе показываем список доступных тестов
else {
	echo '<h3 align="center">Список доступных тестов на данный момент</h3>';
	$testFiles = scandir('tests');
	
	if($_SERVER['HTTP_REFERER'] == 'http://university.netology.ru/u/abaiuly/lesson-2.2/admin.php') {
		$testFiles = uploadFile('testfile', substr($_FILES['testfile']['name'],0, -5));

		if(!$testFiles) {
			echo '<p style="text-align: center;">При загрузке файла произошла ошибка или не выбран файл!</p>';
			echo '<p style="text-align: center;"><a href="list.php">Перейти к списку</a></p>';
		}
	}
}

?>

<table>

<?php for($i = 2; $i < count($testFiles); $i++) : ?>
	<tr>
		<td>&bull; <?='Тест по '.$testfile=substr($testFiles[$i],0,-5);?></td>
		<td><a href="<?="test.php?testfile=$testfile";?>">Начать тест</a></td>
	</tr>
<?php endfor; ?>

</table>

<p style='text-align: center;'><a href="admin.php">Загрузить новый файл</a></p>

</body>
</html>