<div class="d-flex flex-column align-items-center" style="max-width: 50rem; align-content: center;">
	<div class="container" style="margin: auto;">
	<img class="mx-auto" src="<?php echo $data['image']; ?>" style="max-width: 15rem; max-height: 20rem;">
	<h3> <?php echo $data['libelle']." <strong>".$data['marque']."</strong>";?></h3>
	</div>
<form action="" method="get">
	<input type="text" name="uc" value="compte" hidden>
	<input type="text" name="action" value="publierAvis" hidden>
	<input type="text" name="id" value="<?php echo $id; ?>" hidden>
	<textarea class="form-control" name="contenu" placeholder="Saisissez le contenu de votre avis" required></textarea>
	<input class="form-control" type="number" name="note" min="0" max="5" placeholder="Note" required style="max-width: 15rem;min-width: 10rem;">
	<input class="form-control" type="submit" value="Envoyer" style="min-width: 15rem;">
</form>
</div>