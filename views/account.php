<h2>Account edition</h2>

<form method="post" action="<?=BASEURL ?>/index.php/user/account">
	<h3>Change password</h3>
        <label for="lastPassword" class="hidden">Old password</label>
        <input type="password" id="lastPassword" name="oldPassword" placeholder="Old password"> <br>

        <label for="newPassword" class="hidden">New password</label>
        <input type="password" id="newPassword" name="newPassword" placeholder="New password">

        <label for="newPassword2" class="hidden">New password repetition</label> <br>
        <input type="password" id="newPassword2" name="newPassword2" placeholder="New password repetition">

    <h3>Modify mail</h3>
        <label for="updateEmail" class="hidden">New mail</label>
        <input type="updateEmail" id="updateEmail" name="updateEmail" placeholder="New mail"><br>

        <label for="update2Password" class="hidden">Password check</label>
        <input type="update2Password" id="update2Password" name="update2Password" placeholder="Password"><br>

    <input type="submit" value="Save">
</form>
