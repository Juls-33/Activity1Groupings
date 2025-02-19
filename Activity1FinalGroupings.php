<?php
    try{
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            // throw new Exception("Error Processing Request", 1);  
            $obj = json_decode($_POST["myJson"]);
            $user_lName_substr = strtolower(substr($obj ->user_lName,0,1));

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
                <p  id="description">Welcome! Please provide your details below to help us better understand your needs. <b>All fields are required.</b></p>
                <form>
                    <div class="label-container">
                        <label for="fName">First Name:</label>
                        <p id="count-result-fName" class="counter">Character Count: 0/100</p>
                    </div>
                    
                    <br>
                    <input class="inputDesign formInput" type="text" id="fName" name="fName" placeholder="Example: John Doe" maxLength='100' required>
                    
                    <br>
                    <div class="label-container">
                    <label for="lName">Last Name:</label>
                        <p id="count-result-lName" class="counter">Character Count: 0/100</p>
                    </div>
                    <br>
                    <input class="inputDesign" type="text" id="lName" name="lName" placeholder="Example: James" maxLength='100' required>
                    <br>
           
                    <p id="sex">Please select your gender:</p>
                    <div class="radio-group">
                        <input type="radio" id="male" name="gender" value="Male">
                        <label for="male">Male</label>
                   
                        <input type="radio" id="female" name="gender" value="Female">
                        <label for="female">Female</label>
                    </div>
                    <br>
           
                    <label for="userAge">Age:</label>
                    <br>
                    <input class="inputDesign" type="number" id="userAge" name="userAge" placeholder="Example: 18" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                    <br>

                    <div class="label-container">
                        <label for="userAddress">Address:</label>
                        <p id="count-result-uAdd" class="counter">Character Count: 0/150</p>
                    </div>
                    
                    <br>
                    <input class="inputDesign address" type="text" id="userAddress" name="userAddress" placeholder="Example: 123, LeBron Street, Barangay James, Los Angeles City" maxLength='150' required>
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
            //format to JSON
            var gender = document.querySelector('input[name="gender"]:checked') ? document.querySelector('input[name="gender"]:checked').value : null;
            var formData = {
                user_fName: document.getElementById("fName").value,
                user_lName: document.getElementById("lName").value,
                user_address: document.getElementById("userAddress").value,
                user_gender: gender,
                user_age: parseInt(document.getElementById("userAge").value,10),
            };
            //check for errors
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
                //removing error design when it's correct
                const input = document.getElementsByTagName("input");
                for (let i = 0; i < input.length; i++) {
                    if(i==2 || i==3){
                        continue;
                    }
                    input[i].classList.remove("inputDesignError");
                }
                //sending to php and receiving response from server
                var jsonString = JSON.stringify(formData);
                $.ajax({
                    url: "", 
                    type: "POST",
                    data: {myJson : jsonString},
                    success: function(response) {
                        //Cannot classify to a class
                        if (response==="Failed to classify you in a class"){
                            Swal.fire({
                            icon: "warning",
                            title: response,
                            html: '<pre>' + "Your Last name starts with a non character\n\n" + message(formData) + '</pre>',
                            width: 600,
                            padding: "3em",
                            color: "#716add",
                            background: "#fff url()",
                            backdrop: `
                                rgba(0,0,123,0.4)
                                url()
                                left top
                                no-repeat
                            `
                            });
                        }
                        //Successfully classified
                        else{
                            Swal.fire({
                            icon: "success",
                            title: response,
                            html: '<pre>' + message(formData) + '</pre>',
                            width: 600,
                            padding: "3em",
                            color: "#716add",
                            background: "#fff url()",
                            backdrop: `
                                rgba(0,0,123,0.4)
                                url("pictures/yey.gif")
                                center top
                                no-repeat
                            `
                            });
                        }
                        
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
        //formatting submitted data to form
        function message(formData){
            return (
                "Name:<b> " + formData.user_fName + "</b><b> " + formData.user_lName + 
                "</b>\n\nGender:<b> " + formData.user_gender +
                "</b>\n\nAge:<b> " + formData.user_age +
                "</b>\n\nAddress: " + formData.user_address + "</b>"
            );
        }

        //check for error function
        function isError(formData){
            var errorString = ""
            if (!formData.user_fName) {
                errorString +="--First name is empty--\n";
                document.getElementById("fName").classList.add("inputDesignError");
            }
            if(!formData.user_lName){
                errorString +="--Last name is empty--\n";
                document.getElementById("lName").classList.add("inputDesignError");
            }
            if(!formData.user_address){
                errorString +="--Address is empty--\n";
                document.getElementById("userAddress").classList.add("inputDesignError");
            }
            if (formData.user_gender==null) {
                errorString +="--You must select your gender--\n";
            }
            if(!formData.user_age){
                errorString +="--Age is empty/invalid--\n";
                document.getElementById("userAge").classList.add("inputDesignError");
            }
            if(formData.user_age>125){
                errorString +="--Age is invalid--\n";
                document.getElementById("userAge").classList.add("inputDesignError");
            }
            return errorString;
        }
        //text counter
        let input = document.querySelector('#fName');
        let input1 = document.querySelector('#lName');
        let input2 = document.querySelector('#userAddress');
        input.addEventListener('keyup', (e) => {
            counter = document.querySelector('#count-result-fName');
            maxLength = 100;
            counter.innerHTML = `Character Count: ${e.target.value.length}/${maxLength}`
        })
        input1.addEventListener('keyup', (e) => {
            counter = document.querySelector('#count-result-lName');
            maxLength = 100;
            counter.innerHTML = `Character Count: ${e.target.value.length}/${maxLength}`
        })
        input2.addEventListener('keyup', (e) => {
            counter = document.querySelector('#count-result-uAdd');
            counter.innerHTML = `Character Count: ${e.target.value.length}/${maxLength}`
        })
    </script>
</body>
</html>
