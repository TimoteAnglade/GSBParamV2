<div id="bandeau">
<!-- Images En-tête -->
<?php
if(isset($_SESSION['mail'])) {
	if(isAdmin()){?>
<img src="images/logo_2.jpg" alt="GsbLogo" title="GsbLogo"/>
<?php }
else {
	?>
	<img src="images/logo.jpg" alt="GsbLogo" title="GsbLogo"/>
	<?php }
} else { ?>
<img src="images/logo.jpg" alt="GsbLogo" title="GsbLogo"/>
<?php } ?>
</div>
<!--  Menu haut-->
<ul id="menu">
	<li><a href="index.php?uc=accueil"> Accueil </a></li>
	<li><a href="index.php?uc=voirProduits&action=voirProduits"> Nos produits par catégorie </a></li>
	<li><a href="index.php?uc=voirProduits&action=nosProduits"> Nos produits </a></li>
	<li><a href="index.php?uc=gererPanier&action=voirPanier"> Voir son panier </a></li>
	<?php
	if(isset($_SESSION['mail'])) {
		?>
		<li><a href="index.php?uc=compte&action=deconnexion"> Se déconnecter </a></li>
		<?php
		if(isAdmin()){
			?>
			<li><a href="index.php?uc=administrer&action=listeProduits"> Gérer produits </a></li>
			<li><a href="index.php?uc=administrer&action=ajoutProduit"> Ajouter produit </a></li>
			<?php
		}
	}else{
		?>
		<li><a href="index.php?uc=compte&action=connexion"> Se connecter </a></li>
		<li><a href="index.php?uc=compte&action=inscription"> S'inscrire </a></li>
		<?php
		}
?>
</ul>
