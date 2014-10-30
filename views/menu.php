<aside>
    <nav class="Menu">
        <ul class="Menu-ul">
                <li class="MenuItem"><a class="MenuItem-a" href="<?=BASEURL?>">Home</a></li>
            <?php if (user_connected()) { ?>
                <li class="MenuItem"><a class="MenuItem-a" href="<?=BASEURL?>/index.php/note/mine">My notes</a></li>
                <li class="MenuItem"><a class="MenuItem-a" href="<?=BASEURL?>/index.php/note/shared">Shared with me</a></li>
                <li class="MenuItem"><a class="MenuItem-a" href="<?=BASEURL?>/index.php/user/signout">Sign out</a></li>
            <?php } else { ?>
                <li class="MenuItem"><a class="MenuItem-a" href="<?=BASEURL?>/index.php/user/signin">Sign in</a></li>
            <?php }	?>
        </ul>
    </nav>
</aside>
