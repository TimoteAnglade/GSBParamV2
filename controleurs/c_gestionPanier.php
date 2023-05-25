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
		$correct = true;
		foreach($lesProduitsDuPanier as $prod){
			$correct = $correct&&($prod['assez']==1);
		}
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
		$lesProduitsDuPanier = getLesProduitsDuTableau($lesIdProduit);
		$correct = true;
		foreach($lesProduitsDuPanier as $prod){
			$correct = $correct&&($prod['assez']==1);
		}
		if($correct){
			if(creerCommande($lesProduitsDuPanier)){
				$message = "Commande enregistrée";
				supprimerPanier();
			}
			else{
				$message = "Commande échouée";
			}
			include ("vues/v_message.php");
		}
		else{
			$message = "Un des produits n'a pas assez de stock pour la commande.";
			include ("vues/v_message.php");
			$n= nbProduitsDuPanier();
			if($n >0)
			{
				$desIdProduit = getLesIdProduitsDuPanier();
				$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
				$correct = true;
				foreach($lesProduitsDuPanier as $prod){
					$correct = $correct&&($prod['assez']==1);
				}
				include("vues/v_panier.php");
			}
			else
			{
				$message = "panier vide !!";
				include ("vues/v_message.php");
			}
		}
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
	var_dump("GROS CACA QUI PUE");
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
	include("vues/v_accueil.php");
}
?>


