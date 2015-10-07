<?php

//Database variables
$servername = $_ENV['SECRET_DB_HOST'];
$username = $_ENV['SECRET_DB_USER'];
$password = $_ENV['SECRET_DB_PASS'];
$dbname = $_ENV['SECRET_DB_NAME'];

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

	// Check connection
if ($db->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

	//Set encoding to UTF-8
$db->set_charset("utf8");

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Secrets</title>
	<link rel="stylesheet" href="css.css">

</head>
<body>
	<section id="header">
		Secrets
	</section>

	<?php

	$message = "";
	$pass = "";

	if(isset($_POST['message'])){

		if(empty($_POST['message'])){
			$message = "";
		}      
		else 
			$message = $_POST['message'];
	}

	if(isset($_POST['password'])){

		if(empty($_POST['password'])){
			$pass = "";
		}      
		else
			$pass = $_POST['password'];
	}

	$query = "SELECT * from secrets WHERE password='" . md5($pass) . "';";
	$result = $db->query($query);

	//More than one row in the query, meaning the password already exists 
	if($result->num_rows > 0 and strlen($message) > 0 and strlen($pass) > 0)
	{
		$update_query = "UPDATE secrets SET message='" . $message . "' WHERE password='" . md5($pass) . "';";
		$update = $db->query($update_query);
		echo "<section id=\"shared\"> Your secret has been securely shared with me. </section>";
	}
	elseif(strlen($message) > 0 and strlen($pass) > 0){
		$insert_query = "INSERT INTO secrets values('" . md5($pass) . "', '" . $message ."');";
		$insert = $db->query($insert_query);
	}
	?>

	<form id="form" action="secret.php" method="POST" enctype="multipart/form-data">
		<input id="passbox" type="password" name="password" value="" placeholder="Enter your passphrase here">
		<br><br>
		<input id="submitbox" type="submit" value="Submit">
	</form>
	
</body>
</html>
