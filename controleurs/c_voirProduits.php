<?php
// contrôleur qui gère l'affichage des produits
$action = $_REQUEST['action'];
switch($action)
{
	case 'voirProduits' :
	{
		$lesCategories = getLesCategories();
		include("vues/v_categories.php");
		if(isset($_REQUEST['categorie']))
		{
  			$categorie = $_REQUEST['categorie'];	
		}
		else
		{
			$categorie="CH";
		}
		$lesProduits = getLesProduitsDeCategorie($categorie);
		include("vues/v_produitsDeCategorie.php");
		break;
	}
	case 'nosProduits' :
	{
		$lesCategories = getLesCategories();
		include("vues/v_categories.php");
		$lesProduits=getLesProduits();
		include("vues/v_produits.php");
		break;
	}
	case 'ajouterAuPanier' :
	{
		$idProduit=$_REQUEST['produit'];
		$idCont=$_REQUEST['contenance'];
		$qte=intval($_REQUEST['qte']);
		if($qte<1){
			header('Location:index.php?uc=voirProduits&action=detailsProduit&id='.$idProduit);
			break;
		}
		$ok = ajouterAuPanier($idProduit, $idCont, $qte);
		if(!$ok)
		{
			$message = "Erreur d'insertion.";
			include("vues/v_message.php");
		}
		else{
		// on recharge la même page ( NosProduits si pas categorie passée dans l'url')
		if (isset($_REQUEST['categorie'])){
			$categorie = $_REQUEST['categorie'];
			header('Location:index.php?uc=voirProduits&action=voirProduits&categorie='.$categorie);
		}
		else {
			header('Location:index.php?uc=voirProduits&action=nosProduits');
		}
		}
		break;
	}
	case 'detailsProduit' :
	{	
		$id=$_REQUEST['id'];
		$produit=getDetailsProduit($id);
		$conts=getContenances($id);
		$avis=getDataAvis($id);
		$recoTemp=getIdReco($id);
		$reco = [];
		foreach ($recoTemp as $recoTemp2) {
			$reco[] = getDetailsProduit($recoTemp2['id_produit']);
		}
		$prixC = "{";
		foreach($conts as $cont){
			$prixC = $prixC."'".$cont['id_contenance']."' : '".$cont['prix']."', ";
		}
		$prixC = $prixC.'}';
		include("vues/v_detailsProduit.php");
	}
}
?>

