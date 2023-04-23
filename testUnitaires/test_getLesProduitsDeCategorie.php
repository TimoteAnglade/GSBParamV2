<?php 
	require_once("..\modele\bd.produits.inc.php");
	$res = getLesProduitsDeCategorie('CH');
	var_dump($res);
?>