
<h1 class="text-center">Commande n°<?php echo $infos['id']; ?> de l'utilisateur <i><?php echo $infos['mail']; ?></i></h1>

<h6 class="text-center"> Cette commande contiens <strong><?php echo $infos['qte']; ?></strong> articles dont <strong><?php echo $infos['nbProduits']; ?></strong> produits différents.</h6>
<h6 class="text-center"> Cette commande date du <strong>
<?php echo getTextFromDate($infos['dateCommande']);?></strong></h6>

<form class="justify-content-center d-flex" method="POST" action="index.php?uc=gererCommandes&action=modifCommande&id=<?php echo $_REQUEST['id']; ?>&mail=<?php echo $_REQUEST['mail'];?>">
  <div class="input-group" style="max-width: 30%;">
  <input type="submit" value="Modifier l'état" class="form-control btn-primary">
  <select name="etatCde" class="form-select" id="inputGroupSelect04">
    <option value="T" <?php if($infos['etatCde']=="T"){echo 'selected';}?> >En transport</option>
    <option value="P" <?php if($infos['etatCde']=="P"){echo 'selected';}?> >En préparation</option>
    <option value="A" <?php if($infos['etatCde']=="A"){echo 'selected';}?> >Arrivé</option>
    <option value="C" <?php if($infos['etatCde']=="C"){echo 'selected';}?> >Annulé</option>
  </select>
</div>
</form>


<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Contenance</th>
      <th scope="col">Prix</th>
      <th scope="col">Prix réduit</th>
      <th scope="col">Quantité Contenance</th>
      <th scope="col">Stock actuel</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($infos['contenir'] as $cd){
      echo '<tr>';
      echo '<th scope="row">'.$cd['id'].'</th>';
      echo '<td><a href="'.'index.php?uc=voirProduits&action=detailsProduit&id='.$cd['id'].'"><img src="'.$cd['image'].'" style="max-width: 40px;"></a></td>';
      echo '<td>'.$cd['id_contenance'].'</td>';
      echo '<td>'.$cd['prix'].' €</td>';
      echo '<td>'.$cd['prixReduit'].' €</td>';
      echo '<td>'.$cd['qteC'].' ';
      if($cd['qteC']>1){
        echo $cd['unit_pluriel'];
      }
      else{
        echo $cd['unit_intitule'];
      }
      echo '<td>'.$cd['stock'].'</td>';
      echo '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>