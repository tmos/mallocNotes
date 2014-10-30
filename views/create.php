<h2>Create a note</h2>
<form class="CreateNote" method="post" action="<?=BASEURL ?>/index.php/note/create">
    <label for="title" class="hidden">Note title</label>
    <input type="text" id="title" placeholder="Title" name="title">

	<label for="text" class="hidden">Note text (300 max)</label>
    <textarea id="text" name="value" rows="10"  placeholder="Your content…"></textarea>

    <input type="submit" value="Create">
</form>
