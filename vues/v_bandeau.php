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
		if(isAdmin()){
			?>
			<li><a href="index.php?uc=gererProduits&action=listeProduits"> Gérer les produits </a></li>
			<li><a href="index.php?uc=gererProduits&action=stocks"> Gérer les stocks </a></li>
			<li><a href="index.php?uc=gererProduits&action=ajoutProduit"> Ajouter un produit </a></li>
			<li><a href="index.php?uc=gererCommandes&action=listeCommandes"> Gérer les commandes </a></li>
			<li><a href="index.php?uc=gererCommandes&action=voirResultats"> Voir le montant des commandes </a></li>
			<?php
		}
		?>
		<li><a href="index.php?uc=compte&action=deconnexion"> Se déconnecter </a></li>
		<?php
	}else{
		?>
		<li><a href="index.php?uc=compte&action=connexion"> Se connecter </a></li>
		<li><a href="index.php?uc=compte&action=inscription"> S'inscrire </a></li>
		<?php
		}
?>
</ul>
</br>
