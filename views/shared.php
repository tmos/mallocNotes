<h1 class="text-center">Notes shared with me</h1>
<ul class="squarelist">
  <?php
  if($data) {
      foreach($data as $note)
      {
        echo '<li>';
        echo '<p class="text-right text-small">creator: '.$note->creator().'</p>';

        if($note->title()) {
          echo '<h2>'.$note->title().'</h2>';
        }
        echo '<p>'.$note->value().'</p>';
        echo '<div class="bottom">';
            echo '<p class="text-right text-small">'.Note::get_time($note->id()).'</p>';
        echo '</div>';
        echo '</li>';
      }
  } else {
      echo '<p class="text-center">No notes here now...</p>';
  }
  ?>
</ul>
