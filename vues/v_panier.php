<div><img src="images/panier.gif"	alt="Panier" title="panier"/></div>
<div id="produits">

<?php
foreach( $lesProduitsDuPanier as $unProduit) 
{
	// récupération des données d'un produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$image = $unProduit['image'];
	$prix = $unProduit['prix'];
	$qte = $unProduit['qte'];
	// affichage
	?>
	<div class="card">
			<div class="photoCard"><img src="<?php echo $image ?>" alt="image descriptive" /></div>
	<div class="descrCard"><?php echo	$description;?>	</div>
	<div class="prixCard"><?php echo $prix."€/unités" ?></div>
	<div class="qteCard"><?php echo $qte." exemplaires" ?></div>
	<div class="totCard"><strong><?php echo "Total : ".$qte*$prix."€" ?></strong></div>
	<div class="imgCard"><a href="index.php?uc=gererPanier&produit=<?php echo $id ?>&action=supprimerUnProduit" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
	<img src="images/retirerpanier.png" TITLE="Retirer du panier" alt="retirer du panier"></a></div>
	</div>
	<?php
}
?>
<div class="commande">
<a href="index.php?uc=gererPanier&action=viderPanier" onclick="return confirm('Voulez-vous vraiment vider votre panier ?');"><img src="images/nepascommander.jpg" title="Vider le panier" alt="Vider le panier"></a>
</div>
<div class="commande">
<a href="index.php?uc=gererPanier&action=passerCommande"><img src="images/commander.jpg" title="Passer commande" alt="Commander"></a>
</div>
</div>
<br/>