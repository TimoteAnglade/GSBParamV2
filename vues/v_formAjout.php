<div class="container">
	        <h2 class="text-center" style="margin-top: 15px;">Ajout d'un produit</h2>
	        <form action="index.php?uc=gererProduits&action=confirmerAjout" method="POST" enctype="multipart/form-data">
	            <div class="form-group">
	                <label for="id">Code :</label>
	                <input type="text" class="form-control" id="id" name="id" placeholder="ex : c01, f12, p90" required>
	            </div>
	            <div class="form-group">
	                <label for="nom">Nom :</label>
	                <input type="text" class="form-control" id="nom" name="nom" required>
	            </div>
	            <div class="form-group">
	                <label for="description">Description :</label>
	                <input type="text" class="form-control" id="description" name="description" required></textarea>
	            </div>
	            <div class="form-group">
	                <label for="marque">Marque :</label>
	                <select class="form-control" id="marque" name="marque" required>
	                    <?php

	                    // Parcours des marques pour générer les options
	                    foreach ($marques as $marque) {
	                        echo '<option value="'.$marque['id_marque'].'"';
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
	        	<h2 class="text-center" style="margin-top: 15px;">Contenance de base :</h2>
	            <div class="input-group mb-3">
				  <input type="number" name="qte" class="form-control" required>
				  <select class="form-select" id="unite" name="unite" required>
				  	<?php

				  	foreach($unites as $u){
				  		echo '<option value="'.$u['id_unit'].'">'.$u['unit_intitule'].'</option>';
				  	}

				  	?>
				  </select>
				</div>
				<div class="input-group flex-nowrap">
				  <input type="number" class="form-control" placeholder="Prix" name="prix" id="prix" required>
				  <span class="input-group-text" id="addon-wrapping">€</span>
				</div>
				<label for="stock" style="margin-top: 15px;">Stock :</label>
				<input type="number" name="stock" value="0" class="form-control">
				<div class="d-flex justify-content-center" style="width: 100%;">
	            <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Enregistrer</button>
	        	</div>
	        </form>
	</div>