<?php
require_once "func.php";

if(!isset($_GET['testfile'])) {
	die('Параметр не задан!');
}
else {
	$testfile = $_GET['testfile'];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Тесты</title>
	<style>
		table {
			margin: 0 auto;
			width: 350px;
		}
		input {
			margin: 7px 0;
		}
		.testform button[type="submit"] {
			margin: 20px auto;
			display: block;
			text-align: center;
			padding: 10px 20px;
			background-color: #008098;
			color: #fff;
			border: 0;
			cursor: pointer;
			border-radius: 5px;
		}
		.testform button[type="submit"]:hover {
			background-color: #f2f2f2;
			color: #333;
		}
	</style>
</head>
<body>

<h3 align="center">Тест на знание <?=$testfile;?></h3>

<div style='margin: 0 auto; width: 700px;'>
	<p><b>Порядок прохождения теста:</b></p>
	<ol>
		<li>Отвечаете на поставленные вопросы, выбрав <b>единственный</b> правильный вариант.</li>
		<li>По завершению тестирования Вы увидите <b>свой балл</b>, <b>количество ошибок</b>, а также <b>разбор каждого вопроса</b> из теста.</li>
	</ol>
	
	<form action="<?="result.php?testfile=$testfile";?>" method="post" class="testform">
	
<?php

	$test = read_json('tests/'.$testfile.'.json');

	for($i = 0; $i < count($test); $i++) :
	$answers = $test[$i]['Answers'];
?>
		<div>
			<p><b><?=($i+1).'. '.htmlspecialchars($test[$i]['Question']);?></b></p>
			<?php for($k = 0; $k < count($answers, COUNT_RECURSIVE) - 2; $k++) : ?>
				<?php foreach($answers as $item) : ?>
					<label>
						<input name="Answer[<?=$i?>]" type="radio" value="<?=$item['Answer'.$k];?>">
						<?=htmlspecialchars($item['Answer'.$k]);?><br />
					</label>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
		
<?php endfor; ?>
		
		<button type="submit" name="result">Завершить и проверить</button>
	</form>

</div>

</body>
</html>