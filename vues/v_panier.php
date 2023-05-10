<?php 
//var_dump($lesProduitsDuPanier);
?>

<div><img src="images/panier.gif"	alt="Panier" title="panier"/></div>
<div id="produits" class="d-flex">

<?php
foreach($lesProduitsDuPanier as $unProduit) 
{
	// récupération des données d'un produit
	$id = $unProduit['id'];
	$idCont = $unProduit['id_contenance'];
	$description = $unProduit['description'];
	$image = $unProduit['image'];
	$prix = $unProduit['prix'];
	$qte = $unProduit['qte'];
	$nom = $unProduit['libelle'];
	$marque =$unProduit['marque'];
	$qteC = $unProduit['qteC'];
	if($unProduit['qte']>1&&!empty($unProduit['unit_pluriel'])){
        $unite = $unProduit['unit_pluriel'];
    }
    else{
    	$unite = $unProduit['unit_intitule'];
    }
	// affichage
	?>
	<div class="card">
	<div class="photoCard"><a href="?uc=voirProduits&action=detailsProduit&id=<?php echo $id ?>"><img src="<?php echo $image ?>" alt="image descriptive" /></a></div>
	<div class="descrCard"><?php echo $nom." <strong>".$marque."</strong>" ;?>	</div>
	<div class="prixCard"><?php echo $prix."€"; ?></div>
	<div class="qteCard"><?php echo $qte."x ".$qteC." ".$unite;?></div>
	<div class="totCard"><strong><?php echo "Total : ".$qte*$prix."€"; ?></strong></div>
	<div class="imgCard">
	<div>
		<form action="#" method="GET">
			<input type="text" name="uc" value="gererPanier" hidden>
			<input type="text" name="action" value="supprimerUnProduit" hidden>
			<input type="text" name="idp" value="<?php echo $id; ?>" hidden>
			<input type="text" name="idc" value="<?php echo $idCont; ?>" hidden>
			<div class="input-group">
				<input type="number" name="qte" value="<?php echo $qte; ?>" class="form-control">
				<input type="submit" value="Modifier" class="active btn-outline-success ">
			</div>
		</form>
	</div><a href="index.php?uc=gererPanier&action=supprimerUnProduit&idp=<?php echo $id ?>&idc=<?php echo $idCont ?>&qte=-1" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
	<img src="images/retirerpanier.png" TITLE="Retirer du panier" alt="retirer du panier"></a></div>
	</div>
	<?php
}
?>
</div>
<div class="commande">
<a href="index.php?uc=gererPanier&action=viderPanier" onclick="return confirm('Voulez-vous vraiment vider votre panier ?');"><img src="images/nepascommander.jpg" title="Vider le panier" alt="Vider le panier"></a>
</div>
<div class="commande">
<a href="index.php?uc=gererPanier&action=passerCommande" onclick="return confirm('Voulez-vous vraiment passer commande avec le panier actuel ?');"><img src="images/commander.jpg" title="Passer commande" alt="Commander"></a>
</div>
<br/>