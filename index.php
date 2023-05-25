<?php
session_start();
if(!isset($_REQUEST['uc']))
     $uc = 'accueil'; // si $_GET['uc'] n'existe pas , $uc reçoit une valeur par défaut
else
	$uc = $_REQUEST['uc'];
include("vues/v_entete.php") ;
require_once("modele/fonctions.inc.php");
require_once("modele/bd.produits.inc.php");
require_once("modele/bd.avis.inc.php");
require_once("modele/bd.commandes.inc.php");

include("vues/v_bandeau.php") ;

 
switch($uc)
{
	case 'accueil':
		{include("vues/v_accueil.php");break;}
	case 'voirProduits' :
		{include("controleurs/c_voirProduits.php");break;}
	case 'gererPanier' :
		{ include("controleurs/c_gestionPanier.php");break;}
	case 'compte' :
		{ include("controleurs/c_compte.php");break;}
	case 'gererProduits' :
		{ include("controleurs/c_gestionProduits.php");break;}
	case 'gererCommandes' :
		{ include("controleurs/c_gestionCommandes.php");break;}
	default :
		{ include("vues/v_accueil.php");}
}
include("vues/v_pied.html") ;
//test//
?>

