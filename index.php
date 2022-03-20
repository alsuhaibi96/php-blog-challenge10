<?php

session_start();

include 'load.php';

$db = new Database();
$misc = new Misc;
$pages = new Paginator('5','p');

$rows = $db->query('SELECT COUNT(id) FROM entries');
$total = $rows->fetch_row();

$pages->set_total($total[0]);

$entry = $db->getAllEntries("SELECT * FROM entries ORDER BY id DESC ".$pages->get_limit());

?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>OOP Blog</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="js/main.js"></script>
	</head>
	<body>

		<div class="wrapper">
			<?php include 'inc/nav.php' ?>

			<aside class="left">
				<?php
					if($entry) {
						foreach($entry as $entries) {
							echo "
								<article class=' col-4 m-auto pt-5'>
								<div class ='container'>	
								<header class='card bg-secondary''>
								<div class ='card-body  '>	
										<a class='card-title btn btn-dark m-auto ' href='entry.php?id=".$entries->getId()."'>".$entries->getTitle()."</a>
										<span class='entry-id btn btn-danger' data-id='".$entries->getId()."'>".$entries->getId()."</span>
									</header>
								
									</div>
									<div class=' m-auto card-body'>
									<section class='card-title ' >Posted by ".$entries->getAuthor()." on ".$misc->convertDate('jS, F Y', $entries->getTimePosted())."</section>
									<section class='card-title btn btn-info' >".nl2br($entries->getBody())."<br><br></section>
									</div>
							
									</div>
									</article>
									</div>
								<hr>
							";
						}
					} else {
						echo "<h3>No entries found.</h3>";
					}

					echo $pages->page_links();
				?>
			</aside>

			<?php include 'inc/right.php' ?>
		</div>
	</body>
</html>