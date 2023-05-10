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

include("vues/v_bandeau.php") ;

 
switch($uc)
{
	case 'accueil':
		{include("vues/v_accueil.html");break;}
	case 'voirProduits' :
		{include("controleurs/c_voirProduits.php");break;}
	case 'gererPanier' :
		{ include("controleurs/c_gestionPanier.php");break;}
	case 'compte' :
		{ include("controleurs/c_compte.php");break;  }
	case 'administrer' :
		{ include("controleurs/c_gestionProduits.php");break;}
}
include("vues/v_pied.html") ;
//test//
?>

