<?php
require('includ/pdo.php');
require('includ/function.php');
require('includ/request.php');

$page = 1;
$itemPage = 2;
$offset = 0;
if (!empty($_GET['page']) && ctype_digit($_GET['page'])) {
	$page = $_GET['page'];
	$offset = ($page-1) * $itemPage;
} else
	abort404();


$sql = "SELECT * FROM articles WHERE status = 'publish' ORDER BY created_at DESC LIMIT $itemPage OFFSET $offset";
$query = $pdo->prepare($sql);
$query->execute();
$articles = $query->fetchAll();
if (empty($articles)) {
	abort404();
}

$count = countArticle('articles', 'WHERE status = "publish";');

include('includ/header.php'); ?>
    <div class="wrap">
	<h1>Blog Home</h1>
	<?=pageIn($page, $itemPage, $count); ?>
	<section id="articles">
		<?php foreach($articles as $article) { ?>
		<div class ="article">
			<h2> <?=$article['title']; ?> </h2>
			<a href="single.php?id=<?= $article['id'] ?> ">
				<img src="https://picsum.photos/id/<?= $article['id'] + 45; ?>/300/200" alt="">
			</a>
		</div>
		<?php } ?>
	</section>
	<?= pageIn($page, $itemPage, $count); ?>
    </div>

<?php include('includ/footer.php'); ?>
