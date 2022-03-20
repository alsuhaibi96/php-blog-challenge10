<?php

session_start();

include 'load.php';

$db = new Database();
$misc = new Misc();

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
				<?php 
					if(isset($_GET['id'])) {
						$id = $db->conn->real_escape_string(trim($_GET['id']));
						$entry = $db->getEntryById($id);

						foreach($entry as $ent) {
							echo "
								<article>
									<header>
										<a href='entry.php?id=".$ent->getId()."'>".$ent->getTitle()."</a>
									</header>
									<section class='time'>Posted by ".$ent->getAuthor()." on ".$misc->convertDate('jS, F Y', $ent->getTimePosted())."</section>
									<section class='body'>".nl2br($ent->getBody())."<br><br></section>
								</article>
							
								<div class='offcanvas offcanvas-start' tabindex='-1' id='offcanvas' aria-labelledby='offcanvasLabel'>
								<div class='offcanvas-header'>
								  <h5 class='offcanvas-title' id='offcanvasLabel'>Offcanvas</h5>
								  <button type='button' class='btn-close text-reset' data-bs-dismiss='offcanvas' aria-label='Close'></button>
								</div>
								<div class='offcanvas-body'>
								  Content for the offcanvas goes here. You can place just about any Bootstrap component or custom elements here.
								</div>
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