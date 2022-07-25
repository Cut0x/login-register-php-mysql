<?php
	require_once 'config.php';
				
	session_start();

	if(!isset($_SESSION['user_login'])) {
		header("location: ../connexion/login/");
	}
				
	$id = $_SESSION['user_login'];
				
	$select_stmt = $db->prepare("SELECT * FROM tbl_user WHERE user_id=:uid");
	$select_stmt->execute(array(":uid"=>$id));
	
	$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
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
    <!-- ICI LE CODE DE VOTRE BODY -->
    
    Coucou <?= $row['username'] ?> !
	</body>
</html>
