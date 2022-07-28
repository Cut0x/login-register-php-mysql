<?php
require_once "config.php";

if(isset($_REQUEST['btn_register'])) {
	$username = strip_tags($_REQUEST['txt_username']);
	$email = strip_tags($_REQUEST['txt_email']);
	$password = strip_tags($_REQUEST['txt_password']);
		
	if (empty($username)) {
		$errorMsg[] = "Entrez un pseudo";
	} else if (empty($email)) {
		$errorMsg[] = "Entrez un email";
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errorMsg[] = "Entrez un email valide";
	} else if (empty($password)) {
		$errorMsg[] = "Entrez un mot de passe";
	} else if (strlen($password) < 6) {
		$errorMsg[] = "Votre mot de passe doit faire minimum 6 caractères";
	} else {	
		try {	
			$select_stmt=$db->prepare("SELECT username, email FROM tbl_user WHERE username=:uname OR email=:uemail");
			
			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email));
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			
			try {
				if (!isset($errorMsg)) {
					$new_password = password_hash($password, PASSWORD_DEFAULT);
					$new_email = hash("ripemd160", $email);
					
					$insert_stmt=$db->prepare("INSERT INTO tbl_user	(username,email,password) VALUES (:uname,:uemail,:upassword)");				
					
					if ($insert_stmt->execute(array(':uname' =>$username, ':uemail' =>$new_email, ':upassword'=>$new_password))) {
						$registerMsg='Succès de l\'enregistrement !';
						header('location: ../login/');
					}
				}
			} catch(PDOException $e) {
				$errorMsg[] = "Email ou nom d'utilisateur déjà utilisé";
			}
		} catch(PDOException $e) {
			//echo $e
		}
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
		<title>Register</title>
	<head>
	<body>
  		<?php
    			if(isset($errorMsg)) {
      				foreach($errorMsg as $error) {
  			?>
    			<div>
      				<strong><?php echo $error; ?></strong>
    			</div>
  		<?php
      				}
    			}
    			if (isset($registerMsg)) {
  		?>
    		<div>
      			<strong><?php echo $registerMsg; ?></strong>
    		</div>
  		<?php
    			}
  		?>   
  		<h2>Page d'enregistrement</h2>
  		<form method="post" class="form-horizontal">
    			<div class="form-group">
      				<label class="col-sm-3 control-label">
        				Pseudo <span style="color: red;">*</span>
      				</label>
      				<div class="col-sm-6">
        				<input type="text" name="txt_username" class="form-control" placeholder="Entrez un pseudo" />
      				</div>
    			</div>
    			<div class="form-group">
      				<label class="col-sm-3 control-label">Email <span style="color: red;">*</span></label>
      				<div class="col-sm-6">
        				<input type="text" name="txt_email" class="form-control" placeholder="Entrez une email" />
      				</div>
    			</div>
    			<div class="form-group">
      				<label class="col-sm-3 control-label">Mot de passe <span style="color: red;">*</span></label>
      				<div class="col-sm-6">
        				<input type="password" name="txt_password" class="form-control" placeholder="Entre un mot de passe" />
      				</div>
    			</div>
    			<div class="form-group">
      				<div class="col-sm-offset-3 col-sm-9 m-t-15">
        				<input type="submit"  name="btn_register" class="btn btn-primary "  value="Enregistrer">
      				</div>
    			</div>
    			<div class="form-group">
      				<div class="col-sm-offset-3 col-sm-9 m-t-15">
        				Tu as déjà un compte d'enregistré ? <a href="../login/"><p class="text-info">Connecte toi !</p></a>		
      				</div>
    			</div>
    		</form>
	</body>
</html>
