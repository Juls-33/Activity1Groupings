<?php
    session_start();
    if (!isset($_SESSION['arr'])) {
        $_SESSION['arr'] = array();
    }
    $arr = &$_SESSION['arr'];
    if (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0') {
        session_unset();
        session_destroy();
        session_start(); 
    }
    try{
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $obj = json_decode($_POST["myJson"]);
            $action = $obj ->action;
            if (isset($action)) {
                switch ($action) {
                    case 'deleteAll':
                        // delete all record (clue: use unset())
                        break;
                    case 'deleteOne':
                        //delete one record (clue: use unset())
                        break;
                    case 'updateRecord':
                        //Update a record
                        break;
                    case 'showRecords':
                        //add Show all records here (access the array)
                        break;
                    case 'addNewRecord':
                        //Add new record
                        break;
                }
            }
        }
    }catch(Exception $e){
        http_response_code(404);
    }
    function addNewRecord($obj){
            $user_lName_substr = strtolower(substr($obj ->user_lName,0,1));
            $_SESSION['arr'][$obj->user_fName." ".$obj -> user_lName]= array(
                "First Name" => $obj->user_fName,
                "Last Name" => $obj -> user_lName, 
                "User Address" => $obj -> user_address,
                "Gender" => $obj -> user_gender,
                "User Age" => $obj -> user_age,
            );
            determineClass($user_lName_substr, $obj);
    }
    function determineClass($user_lName_substr, $obj){
        if (($user_lName_substr>='a' && $user_lName_substr<='m')&&($obj ->user_gender==="Male")){
            echo ("Registration Complete!\n");
            echo("\nYou Belong in Class A");
        }
        else if (($user_lName_substr>='n' && $user_lName_substr<='z')&&($obj ->user_gender=="Female")){
            echo ("Registration Complete!\n");
            echo("\nYou Belong in Class B");
        }
        else if (($user_lName_substr>='n' && $user_lName_substr<='z')&&($obj ->user_gender=="Male")){
            echo ("Registration Complete!\n");
            echo("\nYou Belong in Class C");
        }
        else if (($user_lName_substr>='a' && $user_lName_substr<='m')&&($obj ->user_gender=="Female")){
            echo ("Registration Complete!\n");
            echo("\nYou Belong in Class D");
        }
        else{
            echo("Failed to classify you in a class");
        }
    }    
?>