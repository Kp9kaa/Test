<?php session_start();?>
<!--Запускаю сессию, чтобы с помощью куки авторизоваться   -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body>
	<header>
		<div class="logo">
			<a href="#"><img class="graphiclogo" src="img/logo.png"></a>
		</div>
		<nav>
			<div class="topnav" id="myTopnav">
				<!-- Ссылки при нажатии на которую, с помощью jQuery, динамически выводится всплывающее меню -->
				<a href="#" class="show_popup" rel="signIn">Войти</a>
				<a href="#" class="show_popup" rel="signUp">Зарегистриваться</a>
			</div>
		</nav>
	</header>
	<div class="overlay_popup"></div>
	<div class="popup">
		<!-- Всплывающее меню для регистрации -->
		<div class="object" id="signUp">
			<form class="postSignUp" method="POST">
				Логин: <input type="text" name="login" required><br>
				Пароль: <input type="password" name="pass" required id="pass"><br>
				<span id="message"></span>
				Подтвердите пароль: <input type="password" required id="conf_pass"><br>
				Email: <input type="text" name="mail" required><br>
				Имя :<input type= "text" name="name" required><br>
				<input type="submit" value="Зарегистрироваться" id="buttonUp">
			</form>
		</div>
		<!-- Всплывающее меню для входа -->
		<div class="object" id="signIn">
			<form class="postSignIn" method="POST">
				<!-- Прошу прощения за php в html -->
				<?php if(!empty($_SESSION['login']))
						{ echo "Вы уже вошли под логином ",$_SESSION['login'];} ?>
				Логин: <input type="text" name="login" required><br>
				Пароль: <input type="password" name="pass" required><br>
				<input type="submit" value="Войти">
				<div id="result"></div>
			</form>
		</div>
	</div>
	<script src="js/jquery-3.3.1.js"></script>
	<script src="js/script.js"></script>
</body>
</html>