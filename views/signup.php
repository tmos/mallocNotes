<h3>Page d'inscription</h3>

<form method="post" action="signup">
	<label for="login">Login</label>
	<input type="text" id="login" name="login">
	<label for="password">Mot de passe</label>
	<input type="password" id="password" name="password">
	<label for="email">Email</label>
	<input type="email" id="email" name="email">	
	<input type="submit">
</form>

<a href="<?=BASEURL?>/index.php/user/signin">Déjà membre?</a>