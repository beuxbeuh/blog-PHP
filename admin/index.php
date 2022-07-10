<?php
require('../includ/pdo.php');
require('../includ/function.php');
require('../includ/request.php');

$count = countArticle();

include('includ/header-back.php'); ?>

<section class="wrap">
	<h1>Dashboard</h1>
	<p>Nombre d'articles : <?= $count; ?></p>
</section>

<?php include('includ/footer-back.php');
