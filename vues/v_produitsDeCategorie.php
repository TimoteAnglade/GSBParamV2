<h2>
	<?php 
	foreach ($lesCategories as $uneCategorie) 
	{
		if($uneCategorie['id']==$categorie)
		{
			$catLib=$uneCategorie['libelle'];
		}
	}
	if(!isset($catLib))
	{
		$catLib='Cheveux';
	}
	echo 'Produits de la catégorie '.$catLib;

?>
</h2>
<div class="produits d-flex flex-row flex-wrap justify-content- align-items-start"  style="flex-direction: column;">
<?php
// parcours du tableau contenant les produits à afficher
foreach( $lesProduits as $unProduit) 
{ 	// récupération des informations du produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
	$marque = $unProduit['marque'];
	$stock = $unProduit['stock'];
	// affichage d'un produit avec ses informations
	?>
	<div class="card p-2 mb-5 mr-ml-3" style="width: 18rem; height: 28rem;
    box-shadow: 3px 3px 5px #bbb;">
			<a class="mx-auto" href="?uc=voirProduits&action=detailsProduit&id=<?php echo $id ?>">
			<img class="card-img-top" src="<?php echo $image ?>" alt=image style="width: 15rem; height: 15rem"/>
			</a>
			<div class="card-body">
			<h4 class="text-center"><?php echo $marque;?></h4>
			<h5 class="text-center descrCard"><?php echo $description ?></h5>
			<form action="" method="GET">
				<input type="text" name="uc" value="voirProduits" hidden>
				<input type="text" name="action" value="detailsProduit" hidden>
				<input type="text" name="id" value="<?php echo $id; ?>" hidden>
				<div class="d-flex align-items-around">
					<div class="p-2"><h6 class="text-center">A partir de <span class="font-weight-bold"><?php echo $prix."€" ?></span></h6></div>
					<div class="p-2"><h6 class="text-center"><span class="font-weight-bold text-<?php if($stock){echo "success\">En stock";}else{echo "danger\">Hors stock";} ?></span></h6></div>
					<input type="submit" value="Voir" class="p-2 form-control btn btn-success">
				</div>
			</form>

			</div>
			
	</div>
<?php			
} // fin du foreach qui parcourt les produits
?>
</div>