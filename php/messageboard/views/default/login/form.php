<div id="loginbox">
	<h1>Login</h1>
	<?php 
    	echo view::show('standard/errors');
	?>
	<form action="/login/process" method="post">
		<div class="row"><label for="username">Username:</label><input type="text" name="username" id="username1" value="<?php if(lib::exists('username')) {echo lib::getitem('username');}?>" /></div>
		<div class="row"><label for="password">Password:</label><input type="password" name="password" id="password1" /></div>
		<div class="row"><label for="submit1"> </label><input id="submit1" type="submit" value="login" class="submitbutton" /></div>
	</form>

	<form action="/login/createAccount" method="post">
		<div class="row"><label for="username">Username:</label><input type="text" name="username" id="username2" value="<?php if(lib::exists('username')) {echo lib::getitem('username');}?>" /></div>
		<div class="row"><label for="password">Password:</label><input type="password" name="password" id="password2" /></div>
        <div class="row"><label for="submit2"> </label><input id="submit2" type="submit" value="create" class="submitbutton" /></div>

	</form>

</div>