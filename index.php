<?php 

// DB CONNECTION
$link = mysqli_connect('localhost', 'root', '', 'filmoteka');

if ( mysqli_connect_error() ) {
	die("Ошибка подключения к базе данных.");
}

$errors = array();

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

// Удаление фильма
if ( @$_GET['action'] == 'delete') {
	$query = "DELETE FROM films WHERE id = ' " . mysqli_real_escape_string($link, $_GET['id'] ) . "' LIMIT 1";

	mysqli_query($link, $query);

	if ( mysqli_affected_rows($link) > 0 ) {
	 	$resultInfo = "<p>Фильм был удален!</p>";
	 } 
	 // else {
	 	// $resultError = "<p>Что то пошло не так.</p>";
	 // }

}



// Save form data to DB
if ( array_key_exists('add-film', $_POST) ) {
	
	// Обработка ошибок
	if ( $_POST['title'] == '') {
		$errors[] = "<p>Необходимо ввести название фильма!</p>";
	}
	if ( $_POST['genre'] == '') {
		$errors[] = "<p>Необходимо ввести жанр фильма!</p>";
	}
	if ( $_POST['year'] == '') {
		$errors[] = "<p>Необходимо ввести год фильма!</p>";
	}

	// Если ошщибок нет - сохраняем фильм
	if ( empty($errors) ) {
		// Запись данных в БД
		$query = "INSERT INTO films (title, genre, year) VALUES (
			'". mysqli_real_escape_string($link, $_POST['title']) ."', 
			'". mysqli_real_escape_string($link, $_POST['genre']) ."', 
			'". mysqli_real_escape_string($link, $_POST['year']) ."'
			)";

		if ( mysqli_query($link, $query) ) {
			$resultSuccess = "<p>Фильм был успешно добавлен!</p>";
		} else { 
			$resultError = "<p>Что то пошло не так. Добавьте фильм еще раз!</p>";
		}
	}



}

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


// Getting films from DB
$query = "SELECT * FROM films";
$films = array();

$result = mysqli_query($link, $query);

if ( $result = mysqli_query($link, $query) ) {
	while ( $row = mysqli_fetch_array($result)  ) {
		$films[] = $row;
	}
}

// echo "<pre>";
// print_r($films);
// echo "</pre>";

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
	<meta charset="UTF-8"/>
	<title>Фильмотека</title>
	<!--[if IE]>
	  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<![endif]-->
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	<meta name="keywords" content=""/>
	<meta name="description" content=""/><!-- build:cssVendor css/vendor.css -->
	<link rel="stylesheet" href="libs/normalize-css/normalize.css"/>
	<link rel="stylesheet" href="libs/bootstrap-4-grid/grid.min.css"/>
	<link rel="stylesheet" href="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.css"/><!-- endbuild -->
<!-- build:cssCustom css/main.css -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&amp;subset=cyrillic-ext" rel="stylesheet">
<!--[if lt IE 9]>
<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
<link rel="stylesheet" href="./css/main.css"/><!-- endbuild -->
  </head>
  <body>
	<div class="container user-content pt-35">

	

	<?php if ( @$resultSuccess != '' ) { ?> 
		<div class="info-success"><?=$resultSuccess?></div>
	<?php } ?>

	<?php if ( @$resultInfo != '' ) { ?> 
		<div class="info-notification"><?=$resultInfo?></div>
	<?php } ?>

	<?php if ( @$resultError != '' ) { ?> 
		<div class="error"><?=$resultError?></div>
	<?php } ?>



	<h1 class="title-1"> Фильмотека</h1>

	<?php foreach ($films as $key => $film) { ?>
		<div class="card mb-20">
			<div class="card__header">
				<h4 class="title-4"><?=$film['title']?></h4>
				<div class="buttons">
				<a href="edit.php?id=<?=$film['id']?>" class="button button--edit">Редактировать</a>
				<a href="?action=delete&id=<?=$film['id']?>" class="button button--delete">Удалить</a>
				</div>
			</div>
			<div class="badge"><?=$film['genre']?></div>
			<div class="badge"><?=$film['year']?></div>
		</div>
	<?php } ?>

	  <div class="panel-holder mt-80 mb-100">
		<div class="title-4 mt-0">Добавить фильм</div>

		<form action="index.php" method="POST">

			<?php 
			if ( !empty($errors)) {
				foreach ($errors as $key => $value) {
				echo "<div class='error'>$value</div>";
				}
			}
			?>

			<label class="label-title">Название фильма</label>
			<input class="input" type="text" placeholder="Такси 2" name="title"/>
			<div class="row">
				<div class="col">
					<label class="label-title">Жанр</label>
					<input class="input" type="text" placeholder="комедия" name="genre"/>
				</div>
				<div class="col">
					<label class="label-title">Год</label>
					<input class="input" type="text" placeholder="2000" name="year"/>
				</div>
			</div>
			<input type="submit" class="button" value="Добавить" name="add-film">
		</form>

	  </div>
	</div><!-- build:jsLibs js/libs.js -->
	<script src="libs/jquery/jquery.min.js"></script><!-- endbuild -->
<!-- build:jsVendor js/vendor.js -->
	<script src="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.js"></script><!-- endbuild -->
<!-- build:jsMain js/main.js -->
	<script src="js/main.js"></script><!-- endbuild -->
	<script defer="defer" src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  </body>
</html>