<div id="accueil">

<h1 id="TitreAcc" class="acc">La société GsbPara,</h1>

<h2 id="Titre2Acc" class="acc"> vous souhaite la bienvenue sur son site de vente en ligne ,</h2>

<p id="TextAcc" class="acc">de produits paramédicaux et bien-être  </p>

<p class="acc">à destination des particuliers.</p>

<p class="acc">Avec plus de 2000 produits paramédicaux à la vente, GsbPara vous propose à 
un tarif compétitif un large panel de produits livré rapidement chez vous !</p>
</div>
<?php 

$nouveautes=getNouveautes(5);

?>
<?php
	if(count($nouveautes)){
	?>
	<h3 class="mt-5 text-center">Nouveautés :</h3>
	<div class="d-flex container mt-5" >
		<?php
		foreach($nouveautes as $item){
			$prix1 = round($item['prix'],2);
			$prix2 = getBestPrix($item['id']);
			if($prix1!=$prix2){
				$prix3="<NOBR><strike><i>".$prix1." €</i></strike> <strong>".$prix2." €</strong></NOBR>";
			}
			else{
				$prix3="<NOBR><strong>".$prix1." €</strong></NOBR>";
			}
		?>


		<div class="card p-2 mb-5 mr-ml-3" style="height: 15rem; max-width: 15rem;min-width: 10rem;">
			<a class="mx-auto" href="?uc=voirProduits&action=detailsProduit&id=<?php echo $item['id'];?>">
			<img src="<?php echo $item['image']; ?>" class="card-img-top" style="max-height: 10rem; max-width: 8rem;">
			</a>
			<div class="card-bot">
				<h5><?php echo $item['libelle']." <strong>".$item['marque']."</strong>";?></h5>
				<h6><?php echo "À partir de ".$prix3;?></h6>
			</div>
		</div>


		<?php
		}
		?>
	</div>
<?php } ?>
<?php

$promotions=getPromotions();
	if(count($promotions)){ ?> 
	<h3 class="mt-5 text-center">Promotions :</h3>
	<?php
		foreach($promotions as $promo) {
	?>
	<h4 class="mt-5 text-center"><?php echo '-'.((1-$promo[0]['reduc'])*100)."%";?> :</h4>
	<div class="d-flex container mt-5" >
		<?php
		foreach($promo as $item){
		?>


		<div class="card p-2 mb-5 mr-ml-3" style="height: 15rem; max-width: 15rem;min-width: 10rem;">
			<a class="mx-auto" href="?uc=voirProduits&action=detailsProduit&id=<?php echo $item['id'];?>">
			<img src="<?php echo $item['image']; ?>" class="card-img-top" style="max-height: 10rem; max-width: 8rem;">
			</a>
			<div class="card-bot">
				<h5><?php echo $item['libelle']." <strong>".$item['marque']."</strong>";?></h5>
				<h6><?php echo "À partir de <strike>".$item['prix']." €</strike><strong> ".round($item['prix']*$item['reduc'], 2)."€</strong>";?></h6>
			</div>
		</div>


		<?php
		} ?> 
	</div> <?php
	}
		?>
<?php } ?>