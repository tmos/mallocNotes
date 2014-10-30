<h3>Notes shared with me</h3>
  <?php
if ($data) {
    foreach ($data as $note) {
        echo '<article class="Note">';
        // TODO with permissions management… one day…
        //echo '<a class="Button Note-button" href="'.BASEURL.'/index.php/note/delete/'.$note->id().'">Delete</a> ';
        //echo '<a class="Button Note-button" href="'.BASEURL.'/index.php/note/edit/'.$note->id().'">Edit</a> ';
        if ($note->title()) {
            echo '<h3 class="Note-title">' . $note->title() . '</h3>';
        }
        echo '<p>creator: ' . $note->creator() . '</p>';
        echo '<time>' . Note::get_time($note->id()) . '</time>';
        echo '<p class="Note-content">' . $note->value() . '</p><br>';
        echo '</article>';
    }
} else {
    echo '<p class="text-center">No notes here now...</p>';
}
?>
