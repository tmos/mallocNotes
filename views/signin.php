<h2 class="PageTitle">Page de connexion</h2>

<div class="Logbox">
    <form class="Logbox-form" method="post" action="signin">
        <label class="hidden" for="login">Login</label>
        <input type="text" id="login" name="login" placeholder="Login">
        
        <label class="hidden" for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Password">
        <input type="submit">
    </form>
</div>

<a href="<?=BASEURL?>/index.php/user/signup">Inscription ?</a>


