<?php
    try{
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            // throw new Exception("Error Processing Request", 1);
            
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
    <title>ContactForm</title>
    <link rel="stylesheet" href="style.css">
    <!-- JQUERY -->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <!-- SWAL 2 -->
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="sweetalert2.min.js">
    </script>
</head>
<body>
    <div class="background">
        <div class="container">
            <div class="design"></div>
            <div class="ContactForm">
                <h1>Personal Information Description</h1>
                <p  id="description">Welcome! Please provide your details below to help us better understand your needs. All fields are required.</p>
                <form>
                    <label for="fName">First Name:</label>
                    <br>
                    <input type="text" id="fName" name="fName" placeholder="Enter your First Name" required>
                    <br>
                    <label for="lName">Last Name:</label>
                    <br>
                    <input type="text" id="lName" name="lName" placeholder="Enter your Last Name" required>
                    <br>
           
                    <p id="sex">Please select your gender:</p>
                    <div class="radio-group">
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                   
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <br>
           
                    <label for="userAge">Age:</label>
                    <br>
                    <input type="number" id="userAge" name="userAge" placeholder="Enter your Age" required>
                    <br>
           
                    <label for="userAddress">Address:</label>
                    <br>
                    <input type="text" id="userAddress" name="userAddress" placeholder="Enter your Address" required>
                    <br>
                    <br>
                   
                    <div class="submit-container">
                        <button type="button" onclick="submitFormViaJSON()" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                    background: "#fff url()",
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("")
                        center
                        no-repeat
                    `
                    });
            }
            else{

                const input = document.getElementsByTagName("input");
                for (let i = 0; i < input.length; i++) {
                    if(i==2 || i==3){
                        continue;
                    }
                    input[i].style.boxShadow= "inset green 0 0 0 2px";
                }
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
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Something went wrong!',
                        });
                    }
                });
            }  
            
   
        }
        function message(formData){
            return (
                "Name:<b> " + formData.user_fName + "</b><b> " + formData.user_lName + 
                "</b>\n\nGender:<b> " + formData.user_gender +
                "</b>\n\nAge:<b> " + formData.user_age +
                "</b>\n\nAddress: " + formData.user_address + "</b>"
            );
        }
        
        function isError(formData){
            var errorString = ""
            if (formData.user_fName.length>=50) {
                errorString +="--First name is too long--\n";
                document.getElementById("fName").style.boxShadow= "red 0 0 0 2px"
            }else if (!formData.user_fName) {
                errorString +="--First name is empty--\n";
                document.getElementById("fName").style.boxShadow= "red 0 0 0 2px"
            }
            if(formData.user_lName.length>=50){
                errorString +="--Last name is too long--\n";
                document.getElementById("lName").style.boxShadow= "red 0 0 0 2px"
            }else if(!formData.user_lName){
                errorString +="--Last name is empty--\n";
                document.getElementById("lName").style.boxShadow= "red 0 0 0 2px"
            }
            if(formData.user_address.length>=100){
                errorString +="--Address is too long--\n";
                document.getElementById("userAddress").style.boxShadow= "red 0 0 0 2px"
            }else if(!formData.user_address){
                errorString +="--Address is empty--\n";
                document.getElementById("userAddress").style.boxShadow= "red 0 0 0 2px"
            }
            for (let char of formData.user_lName) {
                if (char >= '0' && char <= '9') {
                    errorString += "--Last name should not contain numbers.--\n";
                    document.getElementById("lName").style.boxShadow= "red 0 0 0 2px"
                    break;
                }
            }
            if (formData.user_gender==null) {
                errorString +="--You must select your gender--\n";
            }
            if(!formData.user_age){
                errorString +="--Age is empty--\n";
                document.getElementById("userAge").style.boxShadow= "inset red 0 0 0 2px"
            }
            if(formData.user_age>120){
                errorString +="--Age is too big--\n";
                document.getElementById("userAge").style.boxShadow= "inset red 0 0 0 2px"
            }
            return errorString;
        }
    </script>
</body>
</html>
