<?php
$db_host="localhost";
$db_user="root"; // nom d'utilisateur par défaut
$db_password=""; // en général, en localhost, sur windows, il n'y a pas de mot de passe défini
$db_name="tbl_user"; // Ici, mettez le nom de la base de donnée que vous avez créé (pour le tuto, c'est tbl_user)

try { // try nous permet d'essayer la connexion à la base de donnée
	$db=new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password); // Ici c'est une nouvelle connexion avec la base de donnée défini
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOEXCEPTION $e) { // catch qui est attraper nous permet de récupérer l'erreur si il y en a une
	$e->getMessage();
}
?>
