<h2 class="PageTitle">Page d'inscription</h2>

<div class="Logbox">
    <form class="Logbox-form" method="post" action="signup">
        <label for="login" class="hidden">Login</label>
        <input type="text" id="login" name="login" placeholder="login">
        
        <label for="password" class="hidden">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Mot de passe">
        
        <label for="email" class="hidden">Email</label>
        <input type="email" id="email" name="email" placeholder="Email">
        
        <input type="submit">
    </form>
    
    <a href="<?=BASEURL?>/index.php/user/signin">Déjà membre?</a>
</div>

