<h2>My notes <span class="subtitle"></h2>
<a class="Button" href="<?=BASEURL ?>/index.php/note/create">Create new note</a>
<?php
if ($data) {
    foreach ($data as $note) {
        echo '<article class="Note">';
        echo '<a class="Button Note-button" href="' . BASEURL . '/index.php/note/delete/' . $note->id() . '">Delete</a> ';
        echo '<a class="Button Note-button" href="' . BASEURL . '/index.php/note/edit/' . $note->id() . '">Edit</a> ';
        if ($note->title()) {
            echo '<h3 class="Note-title">' . $note->title() . '</h3>';
        }
        echo '<time>' . Note::get_time($note->id()) . '</time>';
        echo '<p class="Note-content">' . $note->value() . '</p><br>';
        echo '</article>';
    }
} else {
    echo '<p>You don\'t have any notes yet :(</p>';
}
?>
