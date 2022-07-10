<?php
require('../includ/pdo.php');
require('../includ/function.php');
require'"../includ/request.php');

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
	$id = $_GET['id'];
	$article = getProduct($id, 'articles');
	if (empty($article))
		abort404();
	else {
		$sql = "UPDATE articles SET status = 'draft', modified_at = NOW() WHERE id = :id";
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		header('Location: listingpost.php');
//		exit;
	}
} else
	abort404();
