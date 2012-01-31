<?php
class user extends dao
{
    protected $table = __CLASS__;

    protected function isAdmin()
    {
    	return true;
    }
    
    
}
?>