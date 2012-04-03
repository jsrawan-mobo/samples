<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:18 PM
 * To change this template use File | Settings | File Templates.
 */
 
class tournamentLoader {


    /**
     * @var $_someVar1
     */
    public $_someVar1;
    public $_someVar2;
    public $_someVar3;
    public $_someVar4;
    public $_someVar5;

    public function defaultaction()
    {
        $this->showAll();
    }

    public function showAll()
    {
        $dummy = 'hello';
        $this->showLoaderInterace($dummy);
    }


    /**
     * @param $dateSelected
     * @return void
     */
    public function showLoaderInterace($dateSelected)
    {

        $gamescoreColl = new gamescoreCollection();
        $gamescoreColl->findAllByUserId(1);


        $header = 'Import Tournament';
        $decription = "Upload a .csv file from";
        echo view::show('tournamentLoader/show', array('type'=>'csv', 'header'=>$header,  'description'=> $decription ) );
    }

/**
 * @throws Exception
 * @param int $hello
 * @return void
 */
    public function processimport()
    {
        if (is_uploaded_file($_FILES['contactsfile']['tmp_name'])) {
            $contents = file_get_contents($_FILES['contactsfile']['tmp_name']);
            unlink ($_FILES['contactsfile']['tmp_name']);

            $builder = new importScoresBuilder($contents);
            $imports = $builder->buildcollection($_POST['importtype']);

            $currentuser = lib::getitem('user');

            foreach ($imports as $import) {
                $contact = new gamescore();

                /**
                 *
                 */
                $adaptor = importAdapter::factory($_POST['importtype']);
                $adaptor->setcontents($import);

                /*
                    Now set the values according to read in by adapter
                */

                $contact->timestamp = "";

                $allPlayersCache = $this->getUserCache();

                if ( isset($allPlayersCache[$adaptor->person1] ) )
                {
                    $contact->fk_User_Id_1 = $allPlayersCache[$adaptor->person1];
                }
                else
                {
                    throw new Exception ("Person1 is not in our player db:" . $adaptor->person1 );
                }

                if ( isset($allPlayersCache[$adaptor->person2] ) )
                {
                    $contact->fk_User_Id_2 = $allPlayersCache[$adaptor->person2];
                }
                else
                {
                    throw new Exception ("Person1 is not in our player db:" . $adaptor->person2 );
                }


                /*
                $contact->fk_User_Id_1 = 1;
                $contact->fk_User_Id_2 = 2;
                 */

                $contact->score_1 = $adaptor->score1;
                $contact->score_2 = $adaptor->score2;

                $contact->save();
            }

            lib::sendto();
        }
        else {
            lib::seterror(array('Please upload a file.'));
            lib::sendto('/tournamentLoader/showLoaderInterace');
        }
    }


    /***
     * This get the user Cache to conver the text names into the users of the system
     *
     * @return - hashmap by username to user object
     */
    public function getUserCache()
    {
        $playersColl = new playerCollection();
        $playersColl->getwithdata();
        $cache = $playersColl->getAllPayerNameCache();
        return $cache;



    }

    /**
     * @param  $someVar1
     */
    public function setSomeVar1($someVar1)
    {
        $this->_someVar1 = $someVar1;
    }

    /**
     * @return
     */
    public function getSomeVar1()
    {
        return $this->_someVar1;
    }

    public function setSomeVar2($someVar2)
    {
        $this->_someVar2 = $someVar2;
    }

    public function getSomeVar2()
    {
        return $this->_someVar2;
    }

    public function setSomeVar3($someVar3)
    {
        $this->_someVar3 = $someVar3;
    }

    public function getSomeVar3()
    {
        return $this->_someVar3;
    }

    public function setSomeVar4($someVar4)
    {
        $this->_someVar4 = $someVar4;
    }

    public function getSomeVar4()
    {
        return $this->_someVar4;
    }

    public function setSomeVar5($someVar5)
    {
        $this->_someVar5 = $someVar5;
    }

    public function getSomeVar5()
    {
        return $this->_someVar5;
    }


}
