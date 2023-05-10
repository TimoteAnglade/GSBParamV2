<?php
if(isset($_SESSION['mail'])){
$action = $_REQUEST['action'];
switch($action)
{
case 'voirPanier':
{
	$n= nbProduitsDuPanier();
	if($n >0)
	{
		$desIdProduit = getLesIdProduitsDuPanier();
		$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
		for($i=0; $i<count($desIdProduit); $i++){}
		include("vues/v_panier.php");
	}
	else
	{
		$message = "panier vide !!";
		include ("vues/v_message.php");
	}
	break;
}
case 'supprimerUnProduit':
{
	$idProduit=$_REQUEST['idp'];
	$idCont=$_REQUEST['idc'];
	$qte=$_REQUEST['qte'];
	modifierQtePanier($idProduit, $idCont, $qte);
	header("Location:?uc=gererPanier&action=voirPanier");
	break;
}
case 'passerCommande' :
{
	$n= nbProduitsDuPanier();
	if($n>0)
	{
		$lesIdProduit = getLesIdProduitsDuPanier();
		if(creerCommande($lesIdProduit)){
			$message = "Commande enregistrée";
			supprimerPanier();
		}
		else{
			$message = "Commande échouée";
		}
		include ("vues/v_message.php");
	}
	else
	{
		$message = "panier vide !!";
		include ("vues/v_message.php");
	}
	break;
}
case 'confirmerCommande' :
{
	$nom =$_REQUEST['nom'];$rue=$_REQUEST['rue'];$ville =$_REQUEST['ville'];$cp=$_REQUEST['cp'];$mail=$_REQUEST['mail'];
	$msgErreurs = getErreursSaisieCommande($nom,$rue,$ville,$cp,$mail);
	if (count($msgErreurs)!=0)
	{
		include ("vues/v_erreurs.php");
		include ("vues/v_commande.php");
	}
	else
	{
		if(creerCommande($nom,$rue,$cp,$ville,$mail, $lesIdProduit )){
			$message = "Commande enregistrée";
			supprimerPanier();
		}
		include ("vues/v_message.php");
	}
	break;
}
case 'viderPanier' :
{
	supprimerPanier();
	header("Location:?uc=gererPanier&action=voirPanier");
	break;
}
}
}
else{
	include("vues/v_accueil.html");
}
?>


