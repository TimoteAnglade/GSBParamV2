	<table>
	<form action=<?php echo '"index.php?uc=administrer&action=confirmerAjout"';?> method="post" enctype="multipart/form-data">
		<th colspan="2">
			<h1>
				Ajout d'un produit
			</h1>
		</th>
		<tr><td width="1500">
	Code du produit :
  		</td><td>
	<input type="text" name="code" id="code" required>
		</td></tr>
		<tr><td>
	Description du produit :
  		</td><td>
	<input type="text" name="description" id="description" required>
		</td></tr>
		<tr><td>
	Prix du produit :
  		</td><td>
	<input type="text" name="prix" id="prix" required>
		</td></tr>
		<tr><td>
  	Image du produit:
  		</td><td width="9000">
  	<input type="file" name="fileToUpload" id="fileToUpload" required>
		</td></tr>
		<tr><td>
	Type du produit :
  		</td><td>
	<select id="categorie" name="categorie" required>
		<?php
	$lesCats=getLesCategories();
	foreach ($lesCats as $cat) {
		?>
		<option 
		value=<?php echo '"'.$cat['id'].'"';?>
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