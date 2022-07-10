<?php
require('includ/pdo.php');
require('includ/function.php');
require('includ/request.php');

if (!empty($_GET['search'])) {
	$search = $_GET['search'];
	$sql = "SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search";
	$query = $pdo->prepare($sql);
	$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
	$query->execute();
	$articles = $query->fetchAll();
}  // else
//	abort404();

include('includ/header.php'); ?>
	<h1>Recherche : <?= $search; ?></h1>
	<section id="articles" class="wrap2">
		<?php foreach ($articles as $article) { ?>
			<div class="article">
				<h2><?= $article['title']; ?></h2>
				<a href="single.php?id=<?= $article['id']; ?>">
					<img src="https://picsum.photos/id/<?= $article['id']+ 45; ?>/300/200" alt=""
				</a>
			</div>
		<?php } ?>
	</section>
<?php include('includ/footer.php');
