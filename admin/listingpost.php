<?php
require('../includ/pdo.php');
require('../includ/function.php');
require('../includ/request.php');

$articles = getAllProduct();
//debug($articles);

include('includ/header-back.php'); ?>

<h1>List Products/Tables</h1>
<ul> <?php foreach ($articles as $article)  { ?>
	<li> <?php echo $article['title']; ?>
		<p> <?= $article['content']; ?></p>
		<h4> <?= $article['auteur']; ?></h4>
		<p> <?= $article['created_at']; ?></p>
		<p> <?= $article['status']; ?></p>
	</li>
	<?php } ?>


<?php include('includ/footer-back.php');
