<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 2/1/12
 * Time: 8:42 PM
 * To change this template use File | Settings | File Templates.
 */
 
class messages {


    public function defaultaction()
	{
		 $this->showAll();
	}

	public function showAll()
	{
        $userName = lib::getitem('username');
        $boardColl = new boardCollection();
        $boardColl->findAll();

        echo view::show('messages/show', array('boardColl'=>$boardColl ) );

    }

	public function newMessage()
	{

        $username =  lib::getitem('username');
        $message = $_POST['message'];


        $newtime = date ("Y-m-d H:i:s");

        $board = new board();
        $board->username =   $username;
        $board->message = $message;
        $board->entered_on = $newtime ; // strtotime("now");;
        $board->saveWithNoId();

        $userName = lib::getitem('username');
        $boardColl = new boardCollection();
        $boardColl->findAll($userName);

        //@TODO, this redirect the url to show.
        echo view::show('messages/show', array('boardColl'=>$boardColl ) );


    }

}
