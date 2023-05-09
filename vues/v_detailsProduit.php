<section class="bg-light">
	<div class="d-flex container">
		<div>
			<img src="<?php echo $produit['image'] ?>">
		</div>
		<div class="">
            <h4><?php echo $produit['libelle'] ?></h4>
            <h5><?php echo $produit['description'] ?></h5>
            <form action="" method="'²'">
            	<input type="text" name="uc" value="voirProduits" hidden>
            	<input type="text" name="action" value="ajouterAuPanier" hidden>
            	<input type="text" name="produit" value="<?php echo $produit['id'] ?>" hidden>
            	<div class="container">
	            	<select id="praticien" name='contenance' class="form-select mt-3" onchange="changePrix(this.value, <?php echo $prixC ?>);">
	                        <?php
	                        $i=0;
	                        $j=0;
	                        foreach ($conts as $cont) {
	                            echo '<option value="'.$cont['id_contenance'].'"class="text-center" ';
	                            if($cont['isBase']){
	                            	$j=$i;
	                                echo 'selected';                                
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
					<h3> <span id="prix"><?php echo $conts[$j]['prix']; ?></span>€ TTC.</h3>
					<div class="input-group">
					<input class="form-control" type="number" name="qte" value="1">
					<input class="btn btn-outline-success btn-block active" type="submit" value="Ajouter au panier">
					</div>

				</div>
            </form>
		</div>
	</div>
</section>