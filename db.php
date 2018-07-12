<?php
	//Запускаю сессию для дальнейшего запоминания
	session_start();
	$welcomeMessage = "Hello, ";
	$deniedMessage = "Неправильный пароль или логин";
	//Загрузка xml файла
	if(file_exists('db/test.xml')){
		$xmlFile = simplexml_load_file('db/test.xml');
	}
	if(isset($_POST['mail'])){
		//Регистрация
		echo signUp($xmlFile);
	}else{
		//Вход
		echo userSearchForSignIn($xmlFile);
	}



	//Функция для случайного генерирования строки для соли
	function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
	    $str = '';
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $str .= $keyspace[random_int(0, $max)];
	    }
	    return $str;
	}

	//Поиск и проверка существующего пользователя
	function userSearchForSignIn($xml){
		global $deniedMessage;
		global $welcomeMessage;
		$login = $_POST['login'];
		foreach ($xml as $user) {
			if((string) $user->login === (string) $login){
				$pass = sha1($_POST['pass'].$user->salt);
				if((string) $pass === (string) $user->pass){

					return $welcomeMessage.$user->name;
				}else{
					return $deniedMessage;
				}
			}
		}
		return $deniedMessage;
	}
	//Проверка существующего пользователя
	function userSearchForSignUp($xml){
		$login = $_POST['login'];
		$mail = $_POST['mail'];
		foreach ($xml as $user){
			if((string) $user->login === (string) $login){
				return "Данный логин уже используется";
			}
			if ((string) $user->mail === (string) $mail){
				return "Данный емейл уже используется";
			}
		}
		return 0;
	}
	//Добавление нового пользователя
	function addUser(&$xml){
		$user = $xml->addChild('user');
		foreach ($_POST as $key => $value) {
			$user->addChild("$key", "$value");
		}
		$salt = random_str(5);
		//Соль хранится в хмл(так как она случайно генерируется)
		$user->addChild("salt", "$salt");
		//Создание хеша на основе пароля и соли
		$user->pass = sha1("$user->pass".$salt);
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());
		$dom->save('db/test.xml');
		$_SESSION['login'] = $_POST['login'];
	}


	
	function signUp(&$xml){
		$temp = userSearchForSignUp($xml);
		if($temp === 0){
			addUser($xml);
			$temp = "Регистрация прошла успешно";
		}
		return $temp;
	}














// //header('Location: B:\OSPanel\domains\test\index.php');
// $dbhost = "localhost";
// $dbname = "test";
// $password = "";
// $username = "root";
// $db = new PDO("mysql:host=$dbhost; dbname=$dbname", $username, $password);
// $_GLOBALS["db"] = $db;
// if($_POST["task"] !== NULL){
// 	set_task($db);
// }


// function get_all($name, &$dbv){

//     $sg = $dbv->query("SELECT * FROM $name ORDER BY datet DESC");
// 	return $sg;
// }

// function get_by_task($name, $task, &$dbv){
// 	$sg = $dbv->query("SELECT * FROM $name WHERE task LIKE '$task'");
// 	return $sg;
// }

// function set_task(&$dbv){
// 	try{
// 		$dbv->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 		$task = ($_POST["task"]);
// 		$status = $_POST["status"];
// 		$comm_POST = $_POST["comm"];
// 		$datet = date("Y-m-d H:i:s");
// 		$pre_status = $_GET["pre_status"];
// 		$id = $_GET["id"];
// 		$sql = "SELECT * FROM $pre_status WHERE id='$id'";
// 		$sg = $dbv->query($sql);
// 		$sg = $sg->fetch(PDO::FETCH_ASSOC);
// 		$comm = unserialize($sg["comm"]);
// 		$comm[] = $comm_POST;
// 		$comm = serialize($comm);

// 		if(isset($sg["id"])){
// 			if($pre_status === $status){
// 				$sql = "UPDATE $status SET
// 		 			task='$task', datet='$datet', comm='$comm'
// 		 			WHERE id='$id'";
// 		 		$dbv->query($sql);
// 			}else{
// 				$sql = "DELETE FROM `$pre_status`
// 						WHERE `id`='$id'";
// 				$dbv->query($sql);
// 				$sql = "INSERT INTO $status(task,datet,comm)
// 						VALUES ('$task', '$datet','$comm')";
// 				$dbv->query($sql);	
// 			}
			
// 		}else{
// 			$sql = "INSERT INTO $status(task, datet)
// 	     			VALUES ('$task', '$datet')";
// 	     	$dbv->query($sql);
// 		}	
// 	}
// 	catch(PDOException $e)
//     {
//     	echo $sql . "<br>" . $e->getMessage();
//     }	

// }	

