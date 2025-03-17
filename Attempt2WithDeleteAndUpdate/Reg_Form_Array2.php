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
                        unset( $_SESSION['arr']);
                        echo "deleted";
                        break;
                    case 'deleteOne':
                        if(isset($_SESSION['arr'][$obj->user_ID])){
                            unset( $_SESSION['arr'][$obj->user_ID]);
                            echo "oneDelete";
                        }else{
                            echo "noID";
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
                            echo "noID";
                        }
                        break;
                    case 'showRecords':
                        $table = '<table style="width: 100%; border-collapse: collapse;">';
                        $table .= '<tr style="background-color: #716add; color: white;">';
                        $table .= '<th style="padding: 8px; border: 1px solid #716add;">ID</th>';
                        $table .= '<th style="padding: 8px; border: 1px solid #716add;">First Name</th>';
                        $table .= '<th style="padding: 8px; border: 1px solid #716add;">Last Name</th>';
                        $table .= '<th style="padding: 8px; border: 1px solid #716add;">Gender</th>';
                        $table .= '<th style="padding: 8px; border: 1px solid #716add;">User Age</th>';
                        $table .= '<th style="padding: 8px; border: 1px solid #716add;">User Address</th>';
                        $table .= '</tr>';
                        foreach ($_SESSION['arr'] as $row) 
                        { 
                            $table .= '<tr style="background-color: #f9f9f9; text-align: center;">';
                            $table .= '<td style="padding: 8px; border: 1px solid #716add;">' . $row['First Name']." ".$row['Last Name']  . '</td>';
                            $table .= '<td style="padding: 8px; border: 1px solid #716add;">' . $row['First Name'] . '</td>';
                            $table .= '<td style="padding: 8px; border: 1px solid #716add;">' . $row['Last Name'] . '</td>';
                            $table .= '<td style="padding: 8px; border: 1px solid #716add;">' . $row['Gender'] . '</td>';
                            $table .= '<td style="padding: 8px; border: 1px solid #716add;">' . $row['User Age'] . '</td>';
                            $table .= '<td style="padding: 8px; border: 1px solid #716add;">' . $row['User Address'] . '</td>';
                            $table .= '</tr>';
                        }
                        $table .= '</table>';
                        echo $table;
                        break;
                    case 'addNewRecord':
                        if(isset($_SESSION['arr'][$obj->user_fName." ".$obj -> user_lName])){
                            echo "IDExist";
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