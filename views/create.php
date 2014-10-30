<h1 class="text-center">Create a note</h1>
<form method="post" action="<?=BASEURL?>/index.php/note/create">
    <div class="formline">
        <label for="title">Note title</label>
        <input type="text" id="title" placeholder="title" name="title">
    </div>
    <div class="formline">
		<label for="text">Note text (300 max)</label>
        <textarea id="text" name="value" rows="10"></textarea>
	</div>
    <div class="formline">
        <label></label>
        <input type="submit" value="Create">
    </div>
</form>
