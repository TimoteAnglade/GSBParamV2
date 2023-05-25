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
					

				</div>
            </form>
		</div>
	</div>
	<div class="container">
	        <h2 class="text-center" style="margin-top: 15px;">Édition de produit</h2>
	        <form action="index.php?uc=gererProduits&action=confirmerEdition&id=<?php echo $id;?>" method="POST" enctype="multipart/form-data">
	            <div class="form-group">
	                <label for="nom">Nom :</label>
	                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $produit['libelle'];?>" required>
	            </div>
	            <div class="form-group">
	                <label for="description">Description :</label>
	                <textarea class="form-control" id="description" name="description" required><?php echo $produit['description'];?></textarea>
	            </div>
	            <div class="form-group">
	                <label for="marque">Marque :</label>
	                <select class="form-control" id="marque" name="marque" required>
	                    <?php

	                    // Parcours des marques pour générer les options
	                    foreach ($marques as $marque) {
	                        echo '<option value="'.$marque['id_marque'].'"';
	                        if($marque['nom_marque']==$produit['marque']){
	                        	echo 'selected';
	                        }
	                        echo '>'.$marque['nom_marque'].'</option>';
	                    }
	                    ?>
	                </select>
	            </div>
	            <div class="form-group">
	                <label for="image">Image :</label>
	                <input type="file" class="form-control-file" id="image" name="image">
	            </div>
	            <div class="form-group">
	                <label for="type">Type :</label>
	                <select class="form-control" id="type" name="type" required>
	                    <option value="CH">Cheveux</option>
	                    <option value="FO">Forme</option>
	                    <option value="PS">Protection Solaire</option>
	                </select>
	            </div>
	            <button type="submit" class="btn btn-primary">Enregistrer</button>
	        </form>
	</div>
	<div class="container" style="margin-top: 15px;">
        <h2 class="text-center">Liste des contenances</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                    <th>Stock</th>
                    <th>Base</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Exemple de données de contenances
                // Parcours des contenances pour générer les lignes du tableau
                foreach ($conts as $contenance) {
                    $id_produit = 123; // Remplacez par l'ID réel du produit

                    echo "<tr>";
                    echo "<td>" . $contenance['id_contenance'] . "</td>";
                    echo "<td>" . $contenance['prix'] . "</td>";
                    echo "<td>" . $contenance['qte'] . "</td>";
                    echo "<td>" . $contenance['unit_intitule'] . "</td>";
                    echo "<td>" . $contenance['stock'] . "</td>";
                    echo "<td>" . ($contenance['isBase'] ? 'Oui' : 'Non') . "</td>";
                    echo "<td><a href=\"index.php?uc=gererProduits&action=editerContenance&id=$id_produit&idContenance=" . $contenance['id_contenance'] . "\" class=\"btn btn-primary\">Éditer</a></td>";
                    echo "</tr>";
                }
                ?>
                <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><a href="index.php?uc=gererProduits&action=nouvelleContenance&id=<?php echo $id?>" class="btn btn-primary">+</a></td></tr>
            </tbody>
        </table>
    </div>




<!--
	<table>
	<form action=<?php echo '"index.php?uc=administrer&produit='.$_REQUEST['produit'].'&action=confirmerEdition"';?> method="post" enctype="multipart/form-data">
		<th colspan="2">
			<h1>
				<?php echo 'Edition du produit '.$_REQUEST['produit'];?>
			</h1>
		</th>
		<tr><td width="1500">
	Description du produit :
  		</td><td>
	<input type="text" name="description" id="description">
		</td></tr>
		<tr><td>
	Prix du produit :
  		</td><td>
	<input type="text" name="prix" id="prix">
		</td></tr>
		<tr><td>
  	Image du produit:
  		</td><td width="9000">
  	<input type="file" name="fileToUpload" id="fileToUpload">
		</td></tr>
		<tr><td>
	Type du produit :
  		</td><td>
	<select id="categorie" name="categorie">
		<?php
	$laCat=getCatProduit($_REQUEST['produit']);
	$lesCats=getLesCategories();
	foreach ($lesCats as $cat) {
		?>
		<option 
		value=<?php echo '"'.$cat['id'].'"';?> 
		<?php if($cat['id']==$laCat){
			echo 'selected';
		}?>
		>
		<?php echo $cat['libelle']?>
		</option>
		<?php
	}
	?>
	</select>
		</td></tr>
		<tr><td>
  	<input type="submit" name="submit">
		</td></tr>
</form>	
</table>




-->