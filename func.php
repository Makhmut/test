<?php

error_reporting(E_ALL & ~E_NOTICE);

// Получение расширение файла
function getExt($file) {
	return substr($file, strpos($file, '.') + 1);
}

// Загрузка файла на сервер
function uploadFile($inputFile, $fileName, $allowedExt = ['json', 'txt']) {
	$uploadDir = 'tests';
	
	// Если файл с таким именем существует
	if(isset($_FILES[$inputFile])) {
		$ext = getExt($_FILES[$inputFile]['name']);
		
		// Если расширение не подходит
		if(!in_array($ext, $allowedExt)) {
			return false;
		}
		
		// Временная директория загружеамого файла
		$sourceFile = $_FILES[$inputFile]['tmp_name'];
		
		// Преобразуем имя загружаемого файла
		$name = "$fileName.$ext";
		
		// Путь для сохранения файла
		$destFile = realpath(__DIR__ . "/$uploadDir").'/'.$name;
		
		// Если файл помещен на $destfile
		if(move_uploaded_file($sourceFile, $destFile)) {
			// Даем список тестов
			$availableTests = scandir('tests');
			return $availableTests;
		}
		else {
			return false;
		}
	}
}

function read_json($file_name) {
	$json = file_get_contents($file_name);
	
	$test = json_decode($json, true);
	return $test;
}

?>