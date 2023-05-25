<section class="bg-light">
	<div class="d-flex container">
		<div>
			<img src="<?php echo $produit['image'] ?>" style="max-width: 70%; max-height: auto;">
		</div>
		<div>
            <h4><?php echo $produit['libelle']." <strong>".$produit['marque'].'</strong>' ?></h4>
            <h5><?php echo $produit['description'] ?></h5>
            <div class="text-center container"><h5><?php 
												$note=getMoy($produit['id']);
												$i=0;
												for($i; $i<$note; $i++){
													echo '⭐';
												}
												for($i; $i<5; $i++){
													echo '★';
												}
												echo '</h5><h6> ('.getNbAvis($produit['id']).' avis)';
												?></h6></div>
			<div class="text-center">
				<?php
				if(isset($_SESSION['mail'])){
					if(canAvis($_SESSION['mail'], $produit['id'])){
						?><a href="?uc=compte&action=redigerAvis&id=<?php echo $produit['id']; ?>">Rédiger un avis</a><?php
					}
				}
				?>
			</div>
            <form action="" method="get" onsubmit="document = new Document; return checkQteAjout(document.getElementById('qte').value, document.getElementById('stockHid').innerHTML);">
            	<input type="text" name="uc" value="voirProduits" hidden>
            	<input type="text" name="action" value="ajouterAuPanier" hidden>
            	<input type="text" name="produit" value="<?php echo $produit['id'] ?>" hidden>
            	<div class="container">
	            	<select id="praticien" name='contenance' class="form-select mt-3" onchange="changePrix(this.value, <?php echo $prixC ?>);">
	                        <?php
	                        $i=0;
	                        $j=0;
	                        $prix1="";
	                        $prix2="";
	                        $prix3="";
	                        foreach ($conts as $cont) {
	                            echo '<option value="'.$cont['id_contenance'].'"class="text-center" ';
	                            if($cont['isBase']){
	                            	$j=$i;
	                                echo 'selected';
									$prix1 = round($cont['prix'],2);
									$prix2 = getBestPromo($cont['id'],$cont["id_contenance"])*$cont['prix'];
									if($prix1!=$prix2){
										$prix3="<NOBR><strike><i>".$prix1." €</i></strike> <strong>".$prix2." €</strong></NOBR>";
									}
									else{
										$prix3="<NOBR><strong>".$prix1." €</strong></NOBR>";
									}                               
	                            }
	                            echo '>'.$cont['qte'].' ';
	                            if($cont['qte']>1&&!empty($cont['unit_pluriel'])){
	                            	echo $cont['unit_pluriel'];
	                            }
	                            else{
	                            	echo $cont['unit_intitule'];
	                            }
	                            echo '</option>';
	                            $i++;
	                        } ?>
					</select>
					<span hidden id="stockHid"><?php echo $conts[$j]['stock'];?></span>
					<div class="container">
						<h3> <span id="prix"><?php echo $prix3; ?></span> TTC.  <span class="text-danger" id="stock2"><em> <span id="stock"> <?php echo $conts[$j]['stock'].'</span> encore en stock'; ?> </em></span></h3>
					</div>
					<div class="input-group">
						<input class="form-control" type="number" id="qte" name="qte" value="1" min="1">
						<input class="btn btn-outline-success btn-block active" type="submit" value="Ajouter au panier">
					</div>

				</div>
            </form>
		</div>
	</div>
</section>
	<?php
		if($reco){
	?>
	<h3 class="mt-5 text-center">Recommandations :</h3>
	<div class="d-flex container mt-5">
		<?php
		foreach($reco as $item){

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
	<div class="d-flex flex-column align-items-between">
		<?php foreach($avis as $avi){
			?>
			<div class="card p2 mb-5 mr-ml-3 text-center" style="max-width: 50%">
				<h4><?php echo $avi['nom'].' '.$avi['prenom']?></h4>
				<h5><?php echo $avi['contenu'];?></h5>
				<h5><?php $i=0;
					for($i; $i<$avi['note']; $i++){
						echo '⭐';
					}
					for($i; $i<5; $i++){
						echo '★';
					}?>
				</h5>
			</div>
			<?php
		}?>
	</div>
<?php
getDataAvis('c01');
?>