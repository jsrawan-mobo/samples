<?php
class logout
{
	public function defaultaction()
	{
		lib::clearAllItems();
		lib::sendto();
	}
}
?>