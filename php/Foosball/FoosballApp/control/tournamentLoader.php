<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:18 PM
 * To change this template use File | Settings | File Templates.
 */
 
class tournamentLoader {


    public function defaultaction()
    {
        $this->showAll();
    }

    public function showAll()
    {
        $dummy = 'hello';
        $this->showLoaderInterace($dummy);
    }


    public function showLoaderInterace($dateSelected)
    {

        $gamescoreColl = new gamescoreCollection();
        $gamescoreColl->findAllByUserId(1);


        $header = 'Import Tournament';
        $decription = "Upload a .csv file from";
        echo view::show('tournamentLoader/show', array('type'=>'csv', 'header'=>$header,  'description'=> $decription ) );
    }

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
                /*
                $contact->firstname = $adaptor->person1;
                $contact->middlename = $adaptor->person2;
                $contact->lastname = $adaptor->score1;
                $contact->ownerid = $currentuser->score2;
                */
                $contact->fk_User_Id_1 = 1;
                $contact->fk_User_Id_2 = 2;

                /*$contact->score_1 = $adaptor->Score1;
                $contact->score_2 = $adaptor->Score2;
                */
                $contact->score_1 = 6;
                $contact->score_2 = 8;

                $contact->save();
            }

            lib::sendto();
        }
        else {
            lib::seterror(array('Please upload a file.'));
            lib::sendto('/tournamentLoader/showLoaderInterace');
        }
    }



}
