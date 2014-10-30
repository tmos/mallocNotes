<h3 class="text-center">Notes shared with me</h3>
  <?php
  if($data) {
      foreach($data as $note)
      {
        echo '<article class="Note">';
        if($note->title()) {
          echo '<h2>'.$note->title().'</h2>';
        }
        echo '<p>creator: '.$note->creator().'</p>';
        echo '<p class="Note-content">'.$note->value().'</p>';
        // TODO with permissions management
        // echo '<a class="Button" href="'.BASEURL.'/index.php/note/edit/'.$note->id().'">Edit</a> ';
        // echo '<a class="Button" href="'.BASEURL.'/index.php/note/delete/'.$note->id().'">Delete</a>';
        echo '<time>'.Note::get_time($note->id()).'</time>';
        echo '</article>';
      }
  } else {
      echo '<p class="text-center">No notes here now...</p>';
  }
  ?>