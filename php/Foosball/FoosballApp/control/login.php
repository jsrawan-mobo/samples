<?php
class login
{
	public function defaultaction()
	{
		 echo view::show('login/form');
	}
	
	public function process()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];		
		
		if (empty($username)) {
			lib::seterror('Please enter a username.');
			lib::sendto('/login');
		}
		
		if (empty($password)) {
			lib::setitem('username', $username);
			lib::seterror('Please enter a password.');
			lib::sendto('/login');
		}
		
		$user = new user(array('User'=>$username));
		
		if ($user)
		
		if (auth::authenticate($user, $password))
        {
            //Now save the logged in player as well.
            $player = new player (array('login'=> $user->User));

			lib::setitem('user', $user);
            lib::setitem('player', $player);
			lib::sendto();
		}
		else {
			lib::setitem('username', $username);
			lib::seterror('Invalid username or password.');
			lib::sendto('/login');
		}
	}
}
?>