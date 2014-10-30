<h1 class="text-center">My notes <span class="subtitle"><a href="<?=BASEURL?>/index.php/note/create">Create new note</a></h1>
<ul class="squarelist">
  <?php
  if($data) {
      foreach($data as $note)
      {
        echo '<li>';
        /* Affiche le createur, comme dans la démo,
        on peut considérer comme logique que mon memo vienne de moi
        echo '<p class="text-right text-small">creator: '.$note->creator().'</p>';
        */
        if($note->title()) {
          echo '<h2>'.$note->title().'</h2>';
        }
        echo '<p>'.$note->value().'</p>';
        echo '<div class="bottom">';
            echo '<p class="text-right"><a href="'.BASEURL.'/index.php/note/edit/'.$note->id().'">Edit</a></p>';
            echo '<p class="text-right text-small">'.Note::get_time($note->id()).'</p>';
        echo '</div>';
        echo '</li>';
      }
  } else {
      echo '<p class="text-center">No notes here now...</p>';
  }
  ?>
</ul>
