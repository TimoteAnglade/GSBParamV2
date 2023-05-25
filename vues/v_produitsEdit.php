<div class="produits d-flex flex-row flex-wrap justify-content- align-items-start"  style="flex-direction: column;">
<?php
//var_dump($lesProduits);
// parcours du tableau contenant les produits à afficher
foreach($lesProduits as $unProduit) 
{ 	// récupération des informations du produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$nom = $unProduit['libelle'];
	$prix1 = round($unProduit['prix'],2);
	$prix2 = getBestPrix($unProduit['id']);
	if($prix1!=$prix2){
		$prix3="<NOBR><strike><i>".$prix1." €</i></strike> <strong>".$prix2." €</strong></NOBR>";
	}
	else{
		$prix3="<NOBR><strong>".$prix1." €</strong></NOBR>";
	}
	$image = $unProduit['image'];
	$marque = $unProduit['marque'];
	$stock = $unProduit['stock'];
	// affichage d'un produit avec ses informations
	?>
	<div class="card p-2 mb-5 mr-ml3" style="width: 18rem; height: 33rem;
    box-shadow: 3px 3px 5px #bbb;">
			<a class="mx-auto" href="?uc=voirProduits&action=detailsProduit&id=<?php echo $id ?>">
			<img class="card-img-top" src="<?php echo $image ?>" alt=image style="width: 15rem; height: 15rem"/>
			</a>
			<div class="card-body">
			<h4 class="text-center"><?php echo $marque;?></h4>
			<h5 class="text-center descrCard"><?php echo $nom ?></h5>
			<form action="" method="GET">
				<input type="text" name="uc" value="voirProduits" hidden>
				<input type="text" name="action" value="detailsProduit" hidden>
				<input type="text" name="id" value="<?php echo $id; ?>" hidden>
				<div class="d-flex align-items-around">
					<div class="p-2"><h6 class="text-center">A partir de <span class="font-weight-bold">

						<?php echo $prix3 ?>



					</span></h6></div>
					<div class="p-2"><h6 class="text-center"><span class="font-weight-bold text-<?php if($stock){echo "success\">En stock";}else{echo "danger\">Hors stock";} ?></span></h6></div>
					<input type="submit" value="Voir" class="p-2 form-control btn btn-success">
				</div>
				<div class="text-center container"><h5><?php 
												$note=getMoy($id);
												$i=0;
												for($i; $i<$note; $i++){
													echo '⭐';
												}
												for($i; $i<5; $i++){
													echo '★';
												}
												echo '</h5><h6> ('.getNbAvis($id).' avis)';
												?></h6></div>
			</form>	
			<a href="index.php?uc=gererProduits&action=editerProduit&produit=<?php echo $id ?>"> 
				<img src="images/edit.png" TITLE="Modifier le produit" alt="Modifier le produit"></a>

				<a href="index.php?uc=gererProduits&action=supprimerProduit&produit=<?php echo $id ?>">
				<img src="images/delete.png" TITLE="Supprimer le produit" alt="Supprimer le produit">
			</a>
			</div>
			
	</div>
<?php			
} // fin du foreach qui parcourt les produits
?>
</div>


