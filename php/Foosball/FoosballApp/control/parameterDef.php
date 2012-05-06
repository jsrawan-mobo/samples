<?php

class parameterDef
{
    
    protected $ALL_USERS = 'All';
    protected $USER_SESSION = 'companyDef_USER_SESSION';

   /* public function showAll()
    {
        $user_session = "";
        if ( lib::exists($this->USER_SESSION) )
        {
            $user_session = lib::getItem($this->USER_SESSION);
        }
        else
        {
            $userObj = lib::getItem('user');
            $user_session = $userObj->User;
        }

        $this->showUser($user_session);
    }
   */
        
    public function showsearchParameters()
    {
        $controller = lib::getitem('controller');
        $careerAcqId =  $controller->params[0];
        $this->showParameters($careerAcqId, "search");

    }


    public function showresultParameters()
    {
        $controller = lib::getitem('controller');
        $careerAcqId =  $controller->params[0];
        $this->showParameters($careerAcqId, "result");
    }


    public function showresumeParameters()
    {
        $controller = lib::getitem('controller');
        $careerAcqId =  $controller->params[0];
        $this->showParameters($careerAcqId, "resume");
    }

    /**
     * @param $algorithmType
     * @param $search_algorithmName
     * @param $result_algorithmName
     * @return null
     */
    public function getParamDescriptions($algorithmType, $search_algorithmName, $result_algorithmName)
    {

        $pd = null;
        for ($i=0 ; $i < 10 ; $i++)
        {
            $name = "description" . "$i";
            $pd->$name =  "NotUsed";
        }

        if ($algorithmType == "search")
        {
            $pd->description0 = "1st Clickthrough Xpath";
            $pd->description1 = "2nd Clickthrough Xpath";
            $pd->description2 = "3rd Clickthrough Xpath";
            $pd->description3 = "4th Clickthrough Xpath";
            $pd->description4 = "5th Clickthrough Xpath";


            switch ($search_algorithmName)
            {
                case "Search_A" :
                {
                    break;
                }
                case "Search_B" :
                {
                    $pd->description5 = "Search Button Xpath";
                    break;
                }
                case "Search_C" :
                {
                    break;
                }
            }
        }

        if ($algorithmType == "result")
        {
            $pd->description0 = "Next button Xpath";

            switch ($result_algorithmName)
            {
                case "Result_A" :
                {

                }
                case "Result_B" :
                {
                    $pd->description0 = "Group XPath";
                    break;
                }
                case "Result_C" :
                {
                    $pd->description0 = "Next Button Xpath";
                    break;
                }
            }
        }


        if ($algorithmType == "resume")
        {
        //not used yet

        }
        return $pd;
    }

    public function showParameters($careerAcqId, $algorithmType)
    {        

        $careerAlgParameterDao = null;
 
        $careerAlgParameterDao = new careeracquisition_algparameter_def();

        $numRecords = $careerAlgParameterDao->numRecords(array('careeracquisition_def_id'=>$careerAcqId, 'algorithm'=>$algorithmType));
 
        if ($numRecords < 1)
        {
            customErrorHandler(E_USER_NOTICE, "Creating parameters for " . $careerAcqId, __FILE__, __LINE__);
            //if not exist, create it
            
            $careerAlgParameterDao = new careeracquisition_algparameter_def();
            $careerAlgParameterDao->careeracquisition_def_id = $careerAcqId;
            $careerAlgParameterDao->algorithm = $algorithmType;

            for ($i=0 ; $i < 10 ; $i++)
            {
                $name = "param" . "$i";
                $careerAlgParameterDao->$name =  "NULL";
            }
            
            $careerAlgParameterDao->saveWithNoId();
 
        }
        else
        {
            $careerAlgParameterDao = new careeracquisition_algparameter_def(array('careeracquisition_def_id'=>$careerAcqId, 'algorithm'=>$algorithmType));

            for ($i=0 ; $i < 10 ; $i++)
            {
                $name = "param" . "$i";
                if ( strlen($careerAlgParameterDao->$name) == 0 )
                {
                    $careerAlgParameterDao->$name = "NULL";
                }
            }
            
        }

        $cadTable = new careeracquisition_def( array('id'=>$careerAcqId) );
        $paramDescriptions = $this->getParamDescriptions($algorithmType, $cadTable->SearchType_Algorithm, $cadTable->ResultType_Algorithm);
        $algorithmName = $algorithmType=="search"?$cadTable->SearchType_Algorithm:$cadTable->ResultType_Algorithm;


        $adTable = new acquisition_def( array('CareerAcquisition_Def_id'=>$careerAcqId) );
 

        //call view

        $header = 'Parameter Definitions';
        $decription = "Company: " . $adTable->Company_Def_ticker_id . " : " . $careerAcqId;
        echo view::show('parameterDef/show', array('header'=>$header,  'description'=>$decription, 'algorithmName'=>$algorithmName, 'careerAlgParameter' => $careerAlgParameterDao, 'paramDescriptions' => $paramDescriptions  ) );
        customErrorHandler(E_USER_NOTICE, "***Finished Show Parameter****", __FILE__, __LINE__);

    }
  

 
    public function updateParameters()
    {
        
        $controller = lib::getitem('controller');
        $careerAcqId =  $controller->params[0];
        if (isset($_POST['close']))
        {
            return;
        }
         
        $algorithmType = $_POST['algorithm'];

        $conditional = array('careeracquisition_def_id'=>$careerAcqId, 'algorithm'=>$algorithmType);
        $careerAlgParameterDao = new careeracquisition_algparameter_def($conditional);

        for ($i=0 ; $i < 10 ; $i++)
        {
            $name = "param" . "$i";
            $careerAlgParameterDao->$name =  $_POST[$name];
        }
        
        $careerAlgParameterDao->updateWithNoId($conditional);
        
        customErrorHandler(E_USER_NOTICE, "***UPDATED RECORD****" . $careerAcqId  . "--" .$algorithmType, __FILE__, __LINE__);
        
        $controller = lib::getitem('controller');
        //TBD: need to uppercase the first letter!!! of algorithm
        lib::sendto("/parameterDef/show" . $algorithmType   . "Parameters/" . $controller->params[0]);
    }        


   /* public function defaultaction()
    {
        $this->showAll();
    }
   */
}

    
?>