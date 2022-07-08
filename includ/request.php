<?php

function getBeer($id)
{
        global $pdo;
        $sql = "SELECT * FROM beer WHERE id = :id";
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
