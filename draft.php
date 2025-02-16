<?php
    try{
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $obj = json_decode($_POST["myJson"]);
            $user_lName_substr = strtolower(substr($obj ->user_lName,0,1));

            if (($user_lName_substr>='a' && $user_lName_substr<='m')&&($obj ->user_gender==="male")){
                echo ("Registration Complete!\n");
                echo("\nYou Belong in Class A");
            }
            else if (($user_lName_substr>='n' && $user_lName_substr<='z')&&($obj ->user_gender=="female")){
                echo ("Registration Complete!\n");
                echo("\nYou Belong in Class B");
            }
            else if (($user_lName_substr>='n' && $user_lName_substr<='z')&&($obj ->user_gender=="male")){
                echo ("Registration Complete!\n");
                echo("\nYou Belong in Class C");
            }
            else if (($user_lName_substr>='a' && $user_lName_substr<='m')&&($obj ->user_gender=="female")){
                echo ("Registration Complete!\n");
                echo("\nYou Belong in Class D");
            }
            exit;

            
        }
    }
    catch(Exception $e){
        http_response_code(404);
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <!-- SWAL 2 -->
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="sweetalert2.min.js">
    </script>
</head>
<body>
    <form> 

        <label for="fName">First Name:</label>
        <br>
        <input type="text" id="fName" name="fName" placeholder="Input First Name" required> 
        <br>

        <label for="lName">Last Name:</label>
        <br>
        <input type="text" id="lName" name="lName" placeholder="Input Last Name" required>
        <br>

        <p>Please select your gender:</p>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Male</label>
        <br>

        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Female</label>
        <br>
        <br>

        <label for="userAge">Age:</label>
        <br>
        <input type="text" id="userAge" name="userAge" placeholder="Input Age" required>
        <br>

        <label for="address">Address:</label>
        <br>
        <input type="text" id="userAddress" name="userAddress" placeholder="Input Address" required>
        <br>
        <br>

        <button type="button" onclick="submitFormViaJSON()" >Submit</button>
        
    </form>
    
    
    <script>
        function submitFormViaJSON(){
            Swal.fire({
                title: 'Form Submitted!',
                text: 'Your form was submitted successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            var gender = document.querySelector('input[name="gender"]:checked') ? document.querySelector('input[name="gender"]:checked').value : null;
            var formData = {
                user_fName: document.getElementById("fName").value,
                user_lName: document.getElementById("lName").value,
                user_address: document.getElementById("userAddress").value,
                user_gender: gender,
                user_age: document.getElementById("userAge").value,
            };
            var errorString = isError(formData);
            if(errorString!=""){
                Swal.fire({
                    icon: "error",
                    title: errorString,
                    width: 600,
                    padding: "3em",
                    color: "#716add",
                    background: "#fff url(/images/trees.png)",
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("/images/nyan-cat.gif")
                        left top
                        no-repeat
                    `
                    });
            }
            else{
                var jsonString = JSON.stringify(formData);
                $.ajax({
                    url: "", 
                    type: "POST",
                    data: {myJson : jsonString},
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: response,
                            // text: message(formData),
                            html: '<pre>' + message(formData) + '</pre>',
                            width: 600,
                            padding: "3em",
                            color: "#716add",
                            background: "#fff url(/images/trees.png)",
                            backdrop: `
                                rgba(0,0,123,0.4)
                                url("/images/nyan-cat.gif")
                                left top
                                no-repeat
                            `
                            });
                    },
                    error: function(response) {
                        // Handle any errors that occur during the request
                        alert("error");
                    }
                });
            }  
            
   
        }
        function message(formData){
            return (
                "Name: " + formData.user_fName + " " + formData.user_lName + 
                "\n\nGender: " + formData.user_gender +
                "\n\nAge: " + formData.user_age +
                "\n\nAddress: " + formData.user_address
            );
        }
        function isError(formData){
            var errorString = ""
            if (formData.user_fName.length>=50) {
                errorString +="First name is too long\n";
            }else if (!formData.user_fName) {
                errorString +="First name is empty\n";
            }
            if(formData.user_lName.length>=50){
                errorString +="Last name is too long\n";
            }else if(!formData.user_lName){
                errorString +="Last name is empty\n";
            }
            if(formData.user_address.length>=100){
                errorString +="Address is too long\n";
            }else if(!formData.user_address){
                errorString +="Address is empty\n";
            }
            for (let char of formData.user_fName) {
                if (char >= '0' && char <= '9') {
                    errorString += "First name should not contain numbers.\n";
                    break;
                }
            }
            
            if(!isNaN(formData.user_fName)||!isNaN(formData.user_lName)){
                errorString +="Must input characters only";
            }
            if(!formData.user_age){
                errorString +="Age is empty";
            }
            if(isNaN(formData.user_age)||formData.user_age>120){
                errorString +="Must input numbers only";
            }
            return errorString;
        }
    </script>
</body>
</html>
