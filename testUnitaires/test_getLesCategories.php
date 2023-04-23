<?php 
	require_once("..\modele\bd.produits.inc.php");
	$res = getLesCategories();
	var_dump($res);
?>