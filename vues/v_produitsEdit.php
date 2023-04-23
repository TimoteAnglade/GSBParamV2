<gdiv id="produits">

<?php
// parcours du tableau contenant les produits à afficher
foreach( $lesProduits as $unProduit) 
{ 	// récupération des informations du produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
	// affichage d'un produit avec ses informations
	?>	
	<div class="card">
			<div class="photoCard"><img src="<?php echo $image ?>" alt=image /></div>
			<div class="descrCard"><?php echo $description ?></div>
			<div class="prixCard"><?php echo $prix."€" ?></div>
			<div class="imgCard">
				<a href="index.php?uc=administrer&produit=<?php echo $id ?>&action=editerProduit"> 
				<img src="images/edit.png" TITLE="Modifier le produit" alt="Modifier le produit"></a>

				<a href="index.php?uc=administrer&produit=<?php echo $id ?>&action=supprimerProduit">
				<img src="images/delete.png" TITLE="Supprimer le produit" alt="Supprimer le produit">
			</a>
			</div>			
	</div>
<?php			
} // fin du foreach qui parcourt les produits
?>
</div>