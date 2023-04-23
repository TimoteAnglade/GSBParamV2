<div id="creationCommande">
<form method="POST" action="index.php?uc=compte&action=confirmationInscription">
   <fieldset>
     <legend>Inscription</legend>
      <p>
         <label for="login">Login*</label>
         <input id="login" type="text" name="login" value="<?php echo $login ?>" size="30" maxlength="45">
      </p>
      <p>
         <label for="password1">Mot de passe*</label>
         <input id="password1" type="password" name="password1" value="<?php echo $password1 ?>" size="30" maxlength="100">
      </p>
      <p>
         <label for="password2">Confirmation*</label>
         <input id="password2" type="password" name="password2" size="30" maxlength="100">
      </p>
      <p>
         <label for="nom">Nom Prénom*</label>
         <input id="nom" type="text" name="nom" value="<?php echo $nom ?>" size="30" maxlength="45">
      </p>
      <p>
         <label for="rue">Rue*</label>
          <input id="rue" type="text" name="rue" value="<?php echo $rue ?>" size="30" maxlength="70">
      </p>
      <p>
         <label for="cp">Code postal* </label>
         <input id="cp" type="text" name="cp" value="<?php echo $cp ?>" size="10" maxlength="5">
      </p>
      <p>
         <label for="ville">Ville* </label>
         <input id="ville" type="text" name="ville"  value="<?php echo $ville ?>" size="70" maxlength="70">
      </p>
      <p>
         <label for="mail">Mail* </label>
         <input id="mail" type="text"  name="mail" value="<?php echo $mail ?>" size ="40" maxlength="40">
      </p> 
      <p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
     </fieldset>
</form>
</div>