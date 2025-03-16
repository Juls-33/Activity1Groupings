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


    /*
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteAll':
                deleteAll();
                break;
            case 'select':
                select();
                break;
        }
    }
    function deleteAll(){
        echo "hi";
    }
        */
    try{
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $obj = json_decode($_POST["myJson"]);
            $action = $obj ->action;
            if (isset($action)) {
                switch ($action) {
                    case 'deleteAll':
                        unset( $_SESSION['arr']);
                        echo "all records deleted";
                        break;
                    case 'deleteOne':
                        if(isset($_SESSION['arr'][$obj->user_ID])){
                            unset( $_SESSION['arr'][$obj->user_ID]);
                            echo "ID: $obj->user_ID was successfully removed.";
                        }else{
                            echo "ID: $obj->user_ID does not exist";
                        }
                        break;
                    case 'updateRecord':
                        if(isset($_SESSION['arr'][$obj->user_ID])){
                            unset( $_SESSION['arr'][$obj->user_ID]);
                            $_SESSION['arr'][$obj->user_fName." ".$obj -> user_lName]= array(
                                "First Name" => $obj->user_fName,
                                "Last Name" => $obj -> user_lName, 
                                "User Address" => $obj -> user_address,
                                "Gender" => $obj -> user_gender,
                                "User Age" => $obj -> user_age,
                            );
                        }
                        else{
                            echo "ID: $obj->user_ID does not exist";
                        }
                        break;
                    case 'showRecords':
                        // $arr[] = $_POST['action'];
                        var_dump($arr);
                        break;
                    case 'addNewRecord':
                        if(isset($_SESSION['arr'][$obj->user_fName." ".$obj -> user_lName])){
                            echo "ID: ". $obj->user_fName." ".$obj ->user_lName." already exist";
                        }else{
                            addNewRecord($obj);
                        }
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
            var_dump( $_SESSION['arr']);
            /*
            for ($row = 0; $row < count($_SESSION['arr']); $row++) {
                echo "<p><b> Row ".$row,"</b></p>";
                echo "<ul>";
                foreach ($_SESSION['arr'][$row] as $x => $y) {
                    echo "<li>".$x.": ".$y."</li>";
                }
                echo "</ul>";
            }*/
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
        /*
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            // throw new Exception("Error Processing Request", 1);  
            $obj = json_decode($_POST["myJson"]);
            $user_lName_substr = strtolower(substr($obj ->user_lName,0,1));

            $arr[] = array("First Name" => $obj->user_fName,
                "Last Name" => $obj -> user_lName, 
                "User Address" => $obj -> user_address,
                "Gender" => $obj -> user_gender,
                "User Age" => $obj -> user_age,
            );
            for ($row = 0; $row < count($arr); $row++) {
                echo "<p><b> Row ".$row+1,"</b></p>";
                echo "<ul>";
                foreach ($arr[$row] as $x => $y) {
                    echo "<li>".$x.": ".$y."</li>";
                }
                
                echo "</ul>";
                }
                determineClass($user_lName_substr, $obj);

            
            exit;

            
        }
    }
    catch(Exception $e){
        http_response_code(404);
    }
    */
    
?>