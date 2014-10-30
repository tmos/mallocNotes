<h1 class="text-center">Edit note</h1>
<form method="post" action="<?=BASEURL?>/index.php/note/edit/<?=$note->id()?>">
    <div class="formline">
        <label for="title">Note title</label>
        <input type="text" name="title" value="<?=$note->title()?>">
    </div>
    <div class="formline">
        <label for="text">Note text (300 max)</label>
        <textarea name="value" rows="10"><?=$note->value()?></textarea>
    </div>
    <div class="formline">
        <label></label>
        <input type="submit" value="Edit">
    </div>
</form>

<form method="post" action="<?=BASEURL?>/index.php/note/edit_share/<?=$note->id()?>">
    <div class="formline">
        <label>Shared with</label>
        <?php
        if($list_user != null) {
            echo '<input type="text" name="share" value='.$list_user.'>';
        }
        else {
            echo '<input type="text" name="share" placeholder="login,login,login...">';
        }
        ?>
    </div>
    <div class="formline">
        <label></label>
        <input type="submit" value="Share">
    </div>
</form>

<form class="noborder" method="post" action="<?=BASEURL?>/index.php/note/delete/<?=$note->id()?>">
    <div class="formline">
        <label></label>
        <input type="submit" value="Delete">
    </div>
</form>
