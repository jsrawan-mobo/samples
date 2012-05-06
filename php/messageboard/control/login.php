<?php
class login
{
    /**
     *
     * This is the default action we call that decide the index for "/" path for controller.
     * @return void
     *
     */
	public function defaultaction()
	{
		 echo view::show('login/form');
	}


    /**
     *
     * Process a login.
     * @return void
     *
     */
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
		
		$users = new users(array('username'=>$username));

		if (auth::authenticate($users, $password))
        {
            //Now save the logged in player as well.
			lib::setitem('user', $users);
			lib::sendto();
		}
		else {
			lib::setitem('username', $username);
			lib::seterror('Invalid username or password.');
			lib::sendto('/login');
		}
	}

    public function createAccount()
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



		if (auth::create($username, $password))
        {
            //Now save the logged in player as well.
            $user = new users (array('username'=> $username) );

			lib::setitem('user', $user);
			lib::sendto();
		}
		else {
			lib::setitem('username', $username);
			lib::seterror('Cannot create account because you are not brilliant');
			lib::sendto('/login');
		}

    }
}
?>