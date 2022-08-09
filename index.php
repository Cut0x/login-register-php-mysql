<?php
	require_once 'config.php'; // cette redirection nous permet de récupérer la variable $db qui est la redirection a notre base de donnée
				
	session_start(); // ici c'est pour lancer la session

	if(!isset($_SESSION['user_login'])) {
		header("location: login.php"); // si la session lancé ne comporte aucune id d'utilisateur, alors le code redirige vers la page de connexion
	}
				
	$id = $_SESSION['user_login']; // ici on récupère l'id de l'utilisateur
				
	$select_stmt = $db->prepare("SELECT * FROM tbl_user WHERE user_id=:uid");
	$select_stmt->execute(array(":uid"=>$id));
	
	$row=$select_stmt->fetch(PDO::FETCH_ASSOC); // ici on récupère toutes les informations de l'utilisateur
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
		<title>Home</title>
	</head>
	<body>
		<h1>Coucou <?= $row['username'] ?> !</h1> 
		<!-- ['username'] nous permet de récupérer l'information "username" qui est dans la base de donné par rapport
		a l'identifiant de session -->
	</body>
</html>
