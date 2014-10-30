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
        <label for="updateMail" class="hidden">New mail</label>
        <input type="text" id="updateMail" name="updateEmail" placeholder="New mail"><br>

        <label for="updateMailPassword" class="hidden">Password check</label>
        <input type="password" id="updateMailPassword" name="updateMailPassword" placeholder="Password"><br>

    <input type="submit" value="Save">
</form>
