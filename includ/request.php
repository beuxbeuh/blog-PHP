<?php

function getProduct($id, string $tables = '')
{
        global $pdo;
	if ($tables == '')
		return(404);
        $sql = "SELECT * FROM $tables WHERE id = :id"; /* :tables */
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch();
}

function getAllProduct($tables = 'articles', $where = 'DESC')
{
        global $pdo;
        $sql = "SELECT * FROM $tables ORDER BY created_at $where";
        $query = $pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll();
}


function dateSite($date)
{
	$retour = 'Date :';
	$retour .= date('d/m/Y à H:i:s', strtotime($date));
	return $retour;
}

function countArticle($tables = 'articles', $option = '')
{
	global $pdo;
	$sql = "SELECT COUNT(id) FROM $tables $option";
	$query = $pdo->prepare($sql);
	$query->execute();
	return $query->fetchColumn();
}
