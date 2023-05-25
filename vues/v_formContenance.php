<h1 class="text-center">Saisie d'une contenance sur le produit <?php echo $infos['id'];?></h1>
<form action="index.php?uc=gererProduits&action=confirmerContenance&id=<?php echo $infos['id'];?>" method="POST" enctype="multipart/form-data">
	<label for="idC">ID Contenance</label>
	<input type="number" name="idC" value="<?php echo $infos['id_contenance'];?>" class="form-control" <?php if(!empty($infos['id_contenance'])){ echo 'readonly'; } ?>>
	<label for="qte">Quantité :</label>
	<div class="input-group mb-3">
		<input type="number" name="qte" class="form-control" value="<?php echo $infos['qte'];?>" required>
		<select class="form-select" id="unite" name="unite" required>
			<?php

			foreach($unites as $u){
				echo '<option value="'.$u['id_unit'].'"';
				if($u['id_unit']==$infos['id_unit']){
					echo 'selected';
				}
				echo '>'.$u['unit_intitule'].'</option>';
			}

			?>
		</select>
	</div>
	<label for="prix" >Prix :</label>
	<div class="input-group flex-nowrap">
		<input type="number" class="form-control" placeholder="Prix" name="prix" id="prix" step="0.01" value="<?php echo $infos['prix'];?>" required>
		<span class="input-group-text" id="addon-wrapping">€</span>
	</div>
	<label for="stock" style="margin-top: 15px;">Stock :</label>
	<input type="number" name="stock" value="0" class="form-control" value="<?php echo $infos['stock'];?>">
	<div class="d-flex justify-content-center" style="width: 100%;">
		<button type="submit" class="btn btn-primary" style="margin-top: 15px;">Enregistrer</button>
	</div>
</form>