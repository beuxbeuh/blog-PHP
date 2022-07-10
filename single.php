<?php
require('includ/pdo.php');
require('includ/function.php');
require('includ/request.php');

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
	$id = $_GET['id'];
	$article = getProduct($id, 'articles'); debug($article);
	if (empty($article))
		header('Location: 404.php');
} else
	abort404();

$sql = "SELECT * FROM comments WHERE id_article = :id";
$query = $pdo->prepare($sql);
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();
$comments = $query->fetchAll();

$errors = [];
if (!empty($_POST['submitted'])) {
	$auteur = cleanXss('auteur');
	$content = cleanXss('content');
	$errors = validText($errors, $auteur, 'auteur', 3, 30);
	$errors = validText($errors, $content, 'content', 3, 1000);
	
	if (count($errors) === 0) {
		$sql = "INSERT INTO comments (id_article,$content,auteur,created_at,modified_at,status) VALUES ( :idarticle, :content, :auteur, NOW(), NOW(), 'new')";
		$query = $pdo->prepare($sql);
		$query->bindValue(':auteur',$auteur,PDO::PARAM_STR);
		$query->bindValue(':content',$content,PDO::PARAM_STR);
		$query->bindValue(':idarticle',$id,PDO::PARAM_INT);
		$query->execute();
		header('Location: single.php?id='.$id);
		// exit;
	}
}

include('includ/header.php'); ?>

<div class="wrap">
	<div class="un_article">
		<h2> <?= $article['title'] ?></h2>
		<p> <?= nl2br($article['content']); /**/ ?></p>
		<p>Author: <?= $article['auteur']; ?></p>
		<p>Publié le : <?= dateSite($article['created_at']); ?></p>
		<?php if($article['created_at'] !== $article['modified_at']) { ?>
			<p>Modifié le : <?= dateSite($article['modified_at']); ?>
		<?php } ?>
	</div>

	<h2> Ajouter un commentaire</h2>
	<form action="" method="post" class="wrap2">
		<label for="auteur">Auteur *</label>
		<input type="text" id="auteur" name="auteur" value="<?= getValue('auteur'); ?>">
		<span class="error"><?= getError($errors,'auteur'); ?></span>

		<label for="content">Commentaire *</label>
		<textarea name="content"><?= getValue('content'); ?></textarea>
		<span class="error"><?= getError($errors,'content'); ?></span>

		<input type="submit" name="submitted" value="Ajouter">
	</form>

	<?php if (!empty($comments)) { ?>
		<h2>Les commentaires</h2>
		<?php foreach ($comments as $comment) { ?>
			<div class="comment">
				<p>Auteur : <?= $comment['auteur']; ?></p>
				<p> <?= $comment['content']; ?></p>
				<hr>
			</div>
		<?php } ?>
	<?php } ?>
</div>

<?php include('includ/footer.php');
