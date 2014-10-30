<h2>Edit note</h2>
<form class="CreateNote" method="post" action="<?=BASEURL ?>/index.php/note/edit/<?=$note->id() ?>">
    <label for="title" class="hidden">Note title</label>
    <input type="text" name="title" value="<?=$note->title() ?>">

    <label for="text" class="hidden">Content</label>
    <textarea name="value" rows="10"><?=$note->value() ?></textarea>

    <input type="submit" value="Edit">
</form>

<h2>Share</h2>
<form method="post" action="<?=BASEURL ?>/index.php/note/edit_share/<?=$note->id() ?>">
    <label for="sharedwith" class="hidden">Shared with</label>
    <?php
        if ($list_user != null) {
            echo '<input id="sharedwith" type="text" name="share" value=' . $list_user . '>';
        } else {
            echo '<input id="sharedwith" type="text" name="share" placeholder="login,login,login...">';
        }
    ?>
    <input type="submit" value="Share">
</form>

<h2>Delete</h2>
<form method="post" action="<?=BASEURL
?>/index.php/note/delete/<?=$note->id() ?>">
        <input type="submit" value="Delete">
</form>
