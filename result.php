<?php

require_once "func.php";

if(!isset($_GET['testfile'])) {
	die('Не задан параметр для определения имени тестового файла!');
}
else {
	$testfile = $_GET['testfile'];
}

if(isset($_POST['result'])) {
	$answers_not_empty = array_filter($_POST['Answer'], function($item) {return !empty($item);});
	if(count($answers_not_empty) < count(read_json('tests/'.$testfile.'.json'))) {
        header('refresh:3;url=list.php');
        echo '<p>Все вопросы требуют ответа! Перенаправление на список тестов.</p>';
        die();
	}
	
	// Правильный ответ
	$correct = 0;
	
	// Неправильный ответ
	$wrong = 0;
	
	// Чтение тестового файла
	$test = read_json('tests/'.$testfile.'.json');
	
	// Пустой массив который будет содержать правильные вариантов ответа
	$correct_answers = array();
	
	// Пройдемся по циклу по .json файла по имени $testfile, которой передаем через $_GET
	for($i = 0; $i < count($test); $i++) {
		// Список ответов из .json файла
		$answers = $test[$i]['Answers'];
		// Ответы пользователя
		$user_answers = $_POST['Answer'][$i];
		
		// Цикл для проверки правильности ответов
		foreach($answers as $item) {
			// Добавим в конец массива $correct_answers корректный вариант ответа,
			// для того чтобы пользователью показать какой ответ правильный
			$correct_answer = $item['Correct_answer'];
			array_push($correct_answers, $correct_answer);
			
			// Если ответ верный увеличиваем на единицу $correct, иначе увеличиваем $wrong
			if($user_answers == $item['Correct_answer']) {
				$correct++;
			}
			else {
				$wrong++;
			}
		}
		
	}
}
else {
	die('Не нажата кнопка завершить и проверить');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Результат тестов</title>
	<style>
		* {
			box-sizing: border-box;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			-o-box-sizing: border-box;
			margin: 0;
			padding: 0;
			border-radius: 5px;
		}
		h3 {
			margin: 15px 0;
			text-align: center;
		}
		p {
			margin: 15px 0;
		}
		.container {
			margin: 0 auto; 
			width: 800px; 
			padding: 25px 0;
		}
		.razbor {
			background-color: #f2f2f2;
			padding: 15px;
			margin-bottom: 25px;
		}
		.razbor:hover {
			background-color: #ccc;
			-webkit-transition: ease all .5s;
		}
		.razbor .question {
			color: blue;
			font-size: 18px;
		}
		.razbor .correct {
			padding: 10px;
			background-color: #fff;
			color: green;
		}
		.razbor .wrong {
			padding: 10px;
			background-color: #fff;
			color: red;
		}
	</style>
</head>
<body>
	<div class="container">
		<h3 style="<?php if($correct > 3) echo 'color: green;'; else echo 'color: red;';?>">
			Ваш результат: <b><?=$correct;?></b> из <?=count($test);?><br />
			<?php echo '('.($correct * 100) / count($test).' %)';?>
		</h3>
		<h3>Разбор каждого вопроса:</h3>
		<?php for($i = 0; $i < count($test); $i++) : ?>
			<div class="razbor">
				<p class="question"><b><?=($i+1).'. '.htmlspecialchars($test[$i]['Question']);?></b></p>
				<p class="<?php if($_POST['q'.$i] == $correct_answers[$i]) echo 'correct'; else echo 'wrong';?>">Вы ответили: <b><?=htmlspecialchars($_POST['Answer'][$i]);?></b></p>
				<p class="correct">Правильный вариант: <b><?=htmlspecialchars($correct_answers[$i]);?></b></p>
			</div>
		<?php endfor; ?>
		<p style='text-align: center;'><a href='<?="list.php";?>'>Вернуться к списку тестов</a></p>
	</div>
</body>
</html>