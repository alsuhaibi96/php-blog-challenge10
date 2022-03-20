<?php

session_start();

include 'load.php';

$db = new Database();
$config = new Config();
$validator = new FormValidator();
$misc = new Misc();

if(isset($_POST['submit'])) {
	$validator->addRule('title', 'Title is a required field', 'required');
	$validator->addRule('body', 'Body is a required field', 'required');

    $validator->addEntries($_POST);
    $validator->validate();
    
    $entries = $validator->getEntries();
    
    foreach ($entries as $key => $value) {
        ${$key} = $value;
    }

    $success = array();
    
    if (!$validator->foundErrors()) {
        $db->query("INSERT INTO entries (title, body, author)
        			VALUES('".$_POST['title']."', '".$_POST['body']."', '".$misc->getSession()."')");
        $success[] = "Your blog has been added.";
    } else {
    	$errors = $validator->getErrors();
    }
}

if(!$misc->loggedIn()) {
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
				<h2 class="ml-5">New Blog</h2>
				<form method="post" action="" class="form p-5 col-6 ">
					<label class="form-label">Title</label>
					<input class="form-control" type="text" name="title" placeholder="Title">
					<label class="form-label">Body</label>
					<textarea class="form-control" cols="70" rows="10" placeholder="Body" name="body"></textarea>
					<input  type="submit" name="submit" value="Add" class="btn btn-primary col-2 mt-2">
				</form>
				<?php
					if(!empty($errors)) {
						foreach($errors as $error => $msg) {
							echo "<div class='error'><span class='msg'>".$msg."</span></div>";
						}
					}

					if(!empty($success) && is_array($success)) {
						foreach($success as $suc) {
							
							echo "
							
							<div class='alert alert-success alert-dismissible fade show col-4' role='alert'>
  <strong>    ".$suc."
  !</strong> 
  
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
						
							";
						}
					}
				?>
			</aside>

			<?php include 'inc/right.php' ?>
		</div>
	</body>
</html>