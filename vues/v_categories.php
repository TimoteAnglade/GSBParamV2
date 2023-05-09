<ul id="categories" class="d-flex flex-column flex-shrink-0 p-3" style="min-height: 100vc">
<?php
foreach( $lesCategories as $uneCategorie) 
{
	$idCategorie = $uneCategorie['id'];
	$libCategorie = $uneCategorie['libelle'];
	?>
	<li>
		<a href="index.php?uc=voirProduits&categorie=<?php echo $idCategorie ?>&action=voirProduits">
		<?php echo $libCategorie ?></a>
	</li>
<?php
}
?>
</ul>

