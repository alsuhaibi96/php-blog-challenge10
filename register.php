<?php

session_start();

include 'load.php';

$db = new Database();
$validator = new FormValidator();
$register = new Register($db);
$misc = new Misc;

if(isset($_POST['submit'])) {
	$validator->addRule('username', 'Username is a required field', 'required');
    $validator->addRule('username', 'Username must be longer than 2 characters', 'minlength', 2);
    $validator->addRule('email', 'Email is a required field', 'required');
    $validator->addRule('password1', 'Password is a required field', 'required');
    $validator->addRule('password2', 'Repeat password is a required field', 'required');

    $validator->addEntries($_POST);
    $validator->validate();
    
    $entries = $validator->getEntries();
    
    foreach ($entries as $key => $value) {
        ${$key} = $value;
    }
    
    if (!$validator->foundErrors()) {
        $register->register(array(
        	$_POST['username'],
        	$_POST['email'],
        	$_POST['password1'],
        	$_POST['password2']
        ));
    } else {
    	$errors = $validator->getErrors();
    }
}

if($misc->loggedIn()) {
	$misc->redirect("index");
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
				<h2 class="ml-5 mt-5">Account Registration</h2>
				<form action="" method="post" class="form col-6 p-5">
					<label class="form-label">Username</label>
					<input class="form-control" type="text" name="username" placeholder="Username">
					<label>Email</label>
					<input  class="form-control"  type="email" name="email" placeholder="Email">
					<label class="form-label">Password</label>
					<input   class="form-control"  type="password" name="password1" placeholder="Password">
					<label class="form-label">Repeat Password</label>
					<input  class="form-control"  type="password" name="password2" placeholder="Repeat Password">
					<input  type="submit" name="submit" value="Register" class="btn btn-primary col-2 mt-3">
				</form>

				<?php
					if(!empty($errors)) {
						foreach($errors as $error => $msg) {
							echo "<div class='error'><span class='msg'>".$msg."</span></div>";
						}
					}

					if(!empty($register->showMessage())) {
						echo "<br><div class='error'><span class='msg'>".$register->showMessage()."</span></div>";
					}
				?>
				<br>
			</aside>

			<?php include 'inc/right.php' ?>
		</div>
	
	</body>
</html>