<h1 class="text-center">Create a note</h1>
<form class="CreateNote" method="post" action="<?=BASEURL ?>/index.php/note/create">
    <div class="formline">
        <label for="title" class="hidden">Note title</label>
        <input type="text" id="title" placeholder="Title" name="title">
    </div>
    <div class="formline">
		<label for="text" class="hidden">Note text (300 max)</label>
        <textarea id="text" name="value" rows="10"  placeholder="Your content…"></textarea>
	</div>
    <div class="formline">
        <label></label>
        <input type="submit" value="Create">
    </div>
</form>
