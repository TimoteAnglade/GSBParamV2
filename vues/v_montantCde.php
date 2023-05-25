<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Mois</th>
      <th scope="col">Chiffre d'affaire</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($resultats as $cd){
      echo '<tr>';
      echo '<th scope="row">'.getMonthFromNumber(month($cd['mois']))." ".year($cd['mois']).'</th>';
      echo '<td>'.$cd['Chiffre d\'affaire'].' €</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>