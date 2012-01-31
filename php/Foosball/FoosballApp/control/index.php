<?php
class index
{
	public function defaultaction()
	{
		if (!auth::isloggedin()) {
			lib::sendto('/login');
		}
		else
		{
		    customErrorHandler(E_USER_NOTICE, "DefaultAction:" , __FILE__, __LINE__);
		    $defaultView = new foosballHome();
		    $defaultView->defaultaction();
		}
	}
}
?>