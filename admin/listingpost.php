<?php
require('../includ/pdo.php');
require('../includ/function.php');
require('../includ/request.php');

$articles = getAllProduct();
//debug($articles);

include('includ/header-back.php'); ?>

<h1>List Products/Tables</h1>
<table>
	<thead>
	 <tr>
		<th>Id</th>
		<th>Title</th>
		<th>Content</th>
		<th>Autor</th>
		<th>Created</th>
		<th>status</th>
		<th>Btn Edit</th>
	 </tr>
	</thead>
	<tbody>
	<?php foreach ($articles as $article)  { ?>
	 <tr>
		<td> <?= $article['id'] ?></td>
		<td> <?= $article['title']; ?></td>
		<td> <?= $article['content']; ?></td>
		<td> <?= $article['auteur']; ?></td>
		<td> <?= $article['created_at']; ?></td>
		<td> <?= $article['status']; ?></td>
		<td><button><a href="editpost.php?id=<?=$article['id']; ?>">Edit</a></button></td>
	 </tr>
	<?php } ?>
	</tbody>
</table>

<?php include('includ/footer-back.php');
