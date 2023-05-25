<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Email</th>
      <th scope="col">Date Commande</th>
      <th scope="col">Etat de la commande</th>
      <th scope="col">Détails</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($cds as $cd){
      echo '<tr>';
      echo '<th scope="row">'.$cd['id'].'</th>';
      echo '<td>'.$cd['mail'].'</td>';
      echo '<td>'.$cd['dateCommande'].'</td>';
      echo '<td>'.$cd['etatCde'].'</td>';
      echo '<td>'.'<a href="index.php?uc=gererCommandes&action=modifCommande&id='.$cd['id'].'&mail='.$cd['mail'].'">Détails</a>'.'</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
