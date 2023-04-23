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