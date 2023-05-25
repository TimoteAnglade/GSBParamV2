<h1 class="text-center">Liste des contenances :</h1>

<table class="table" style="margin-top: 15px;">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Intitulé</th>
      <th scope="col">ID Contenance</th>
      <th scope="col">Prix</th>
      <th scope="col">Quantité</th>
      <th scope="col">Catégorie</th>
      <th scope="col">Stock</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($infos as $cd){
      echo '<tr>';
      echo '<td>'.$cd['id'].'</td>';
      echo '<td>'.$cd['libelle'].'</td>';
      echo '<td>'.$cd['id_contenance'].'</td>';
      echo '<td>'.$cd['prix'].' €</td>';
      if($cd['qte']>1){
        echo '<td>'.$cd['qte'].' '.$cd['unit_intitule'].'</td>';
      }
      else{
        echo '<td>'.$cd['qte'].' '.$cd['unit_pluriel'].'</td>';
      }
      echo '<td>'.$cd['id'].'</td>';
      echo '<td>';
      ?>

      <form action="index.php?uc=gererProduits&action=modifStock&id=<?php echo $cd['id'];?>&idC=<?php echo $cd['id_contenance'];?>" method="POST"> <div class="input-group"><input type="number" value="<?php echo $cd['stock']; ?>" class="form-control" name="stock"><button type="submit" class="form-control btn-primary">Modifier</button> </div></form>

      <?php
      echo '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>