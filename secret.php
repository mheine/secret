<?php

//Database variables
$servername = $_ENV['SECRET_DB_HOST'];
$username = $_ENV['SECRET_DB_USER'];
$password = $_ENV['SECRET_DB_PASS'];
$dbname = $_ENV['SECRET_DB_NAME'];

echo $username;

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

	// Check connection
if ($db->connect_error) {
	die("Connection failed: " . "  also?? " . $username . $conn->connect_error);
}

	//Set encoding to UTF-8
$db->set_charset("utf8");

?>

<!-- BEGIN HTML-->
<html>
<head>
	<meta charset="UTF-8">
	<title>Secrets</title>

	<link rel="stylesheet" href="css.css">

</head>
<body>
	<section id="header">
 			<a href="https://mheine.se/secret">Secrets</a>
 	</section>

		<?php
		$pass = $_POST['password'];
		$message = "";

			//Create and execute query for the different districts available
		$d_lan_q = "SELECT message FROM secrets WHERE password='" . md5($pass) . "';";
		$d_lan = $db->query($d_lan_q);


		if ($d_lan->num_rows > 0) {
    // output data of each row
			while($row = $d_lan->fetch_assoc()) {
				$message = $row["message"];
			}
		} else {
		}

		?>

	<textarea id="textmessage" name="message" form="mess_submit" rows="1000" cols="1000"><?php echo $message ?></textarea>

	<form action="index.php" id="mess_submit" method="POST">
		<input id="submitmessage" type="submit">
		<input type="hidden" name="password" value="<?php echo $pass ?>">
	</form>

</body>
</html>
