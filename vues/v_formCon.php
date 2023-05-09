<div id="creationCommande">
<form method="POST" action="index.php?uc=compte&action=confirmationConnexion">
   <fieldset>
     <legend>Connexion</legend>
      <p>
         <label for="login">Mail</label>
         <input id="mail" type="text"  name="mail" value="<?php echo $mail ?>" size ="40" maxlength="40">
      </p> 
      <p>
         <label for="password">Mot de passe</label>
         <input id="password" type="password"  name="password" value="<?php echo $password ?>" size ="40" maxlength="40">
      </p> 
      <p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
     </fieldset>
</form>
</div>