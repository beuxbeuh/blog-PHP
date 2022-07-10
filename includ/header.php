<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Front Office</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php?page=1">Home</a></li>
            <li><a href="admin/index.php">Admin</a></li>
    <div id="search" class="wrap2">
	<form action="search.php" method="get">
	    <input type="search" name="search" placeholder="recherche" value="<?php if(!empty($_GET['search'])) {echo $_GET['search'];} ?>">
	    <span style='background-color: black;'></span>
	</form>
        </ul>
    </div>
    </nav>
</header>
<div id="content">

