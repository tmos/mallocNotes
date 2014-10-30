<h3 class="text-center">My notes <span class="subtitle"></h3>
<a href="<?=BASEURL?>/index.php/note/create">Create new note</a>
<?php
if ($data) {
    foreach($data as $note)
    {
        echo '<article class="Note">';
            if ($note->title()) {
                echo '<h3>'.$note->title().'</h3>';
            }
            echo '<p class="Note-content">'.$note->value().'</p>';
            echo '<a class="Button" href="'.BASEURL.'/index.php/note/edit/'.$note->id().'">Edit</a> ';
            echo '<a class="Button" href="'.BASEURL.'/index.php/note/delete/'.$note->id().'">Delete</a>';
            echo '<time>'.Note::get_time($note->id()).'</time>';
        echo '</article>';
    }
} else {
    echo '<p class="text-center">No notes yet :(</p>';
}

?>
