<?php

session_start();

include 'load.php';

$db = new Database();
$validator = new FormValidator();
$login = new Login($db);
$misc = new Misc;

if(isset($_POST['submit'])) {
	$validator->addRule('username', 'Username is a required field', 'required');
    $validator->addRule('username', 'Username must be longer than 2 characters', 'minlength', 2);
    $validator->addRule('password1', 'Password is a required field', 'required', 'minlength', 6);

    $validator->addEntries($_POST);
    $validator->validate();
    
    $entries = $validator->getEntries();
    
    foreach ($entries as $key => $value) {
        ${$key} = $value;
    }
    
    if (!$validator->foundErrors()) {
        $login->login(array(
        	$_POST['username'],
        	$_POST['password1']
        ));
    } else {
    	$errors = $validator->getErrors();
    }
}

if($misc->loggedIn()) {
	$misc->redirect("index.php");
}

?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>OOP Blog</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>

		<div class="wrapper">
			<?php include 'inc/nav.php' ?>

			<aside class="left">
				<h2 class="ml-5 mt-5"> Account Login</h2>
				<form action="" method="post" class="form p-5 col-6">
					<label class="form-label">Username</label>
					<input class="form-control" type="text" name="username" placeholder="Username">
					<label class="form-label">Password</label>
					<input class="form-control" type="password" name="password1" placeholder="Password">
					<input class="btn btn-primary mt-2 col-2" type="submit" name="submit" value="Login">
				</form>

				<?php
					if(!empty($errors)) {
						foreach($errors as $error => $msg) {
							echo "<div class='error'><span class='msg'>".$msg."</span></div>";
						}
					}

					if(!empty($login->showMessage())) {
						echo "<br><div class='error'><span class='msg'>".$login->showMessage()."</span></div>";
					}
				?>
			</aside>

			<?php include 'inc/right.php' ?>
		</div>
	
	</body>
</html>