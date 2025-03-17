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

    echo "<br>";
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
                <!--Dynamic content goes here -->
                <!-- SPA -->
            </div>
        </div>
    </div>
    <script>
    showAddRecordPage();
    //SPA DYNAMIC CONTENTS
    function showEditPage(){
        document.getElementsByClassName("ContactForm")[0].innerHTML =`
            <h1>Database Editor</h1>
                <p  id="description">Click a button to delete all records, Delete a record, update a record, view all records, or add new record</p>
                <div class="submit-container">
                        <button type="button"  class="button" id="deleteAll" name="deleteAll" value="deleteAll" onclick="deleteAllRec()">Delete All</button>
                    </div><br>
                    <div class="submit-container">
                        <button type="button"  class="button" id="deleteOnePage" value="deleteOnePage" onclick="showDeleteOnePage()">Delete a record</button>
                    </div><br>
                    <div class="submit-container">
                        <button type="button" class="button" id="updateRecordPage" value="updateRecordPage" onclick="showUpdatePage()">Update a record</button>
                    </div><br>
                    <div class="submit-container">
                        <button type="button" class="button" id="showRecords" value="showRecords" onclick="showAllRec()">Show All Records</button>
                    </div><br>
                    <div class="submit-container">
                        <button type="button" class="button" id="AddNewRecordPage" value="AddNewRecordPage" onclick="showAddRecordPage()">Add New Record</button>
                    </div>`;
    }
    function showAddRecordPage(){
        document.getElementsByClassName("ContactForm")[0].innerHTML =`
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
                        <button type="button"  id="submit" value="addNew" onclick="submitFormViaJSON()">Submit</button>
                    </div><br>
                    <div class="submit-container">
                        <button type="button" class="button" id="editRecord" value="editRecord" onclick="showEditPage()">Edit Record</button>
                    </div>
                </form>`;
                addTextCounter();
                
    }
    function showDeleteOnePage(){
        document.getElementsByClassName("ContactForm")[0].innerHTML =`
        <h1>Delete A Record</h1>
        <p  id="description">Enter the ID (First name and Last name) of the record that you would like to delete</p>
        <form>
            <div class="label-container">
                <label for="deleteOneInp">Delete a Record:</label>
            </div>
            <br>
            <input class="inputDesign formInput" type="text" id="deleteOneInp" name="deleteOneInp" placeholder="Example: John Doe" maxLength='100' required>
            <div class="submit-container">
                <button type="button"  class="button" id="deleteOne" value="deleteOne" onclick="deleteOneRec()">Delete a record</button>
            </div><br>
            <div class="submit-container">
                <button type="button"  class="button" id="showRecords" value="showRecords" onclick="showAllRec()">Show All Records</button> 
            </div><br>
            <div class="submit-container">
                <button type="button"  class="button" id="editRecord" value="editRecord" onclick="showEditPage()">Back</button>
            </div>
            
        </form>
        `
        
    }
    function showUpdatePage(){
        document.getElementsByClassName("ContactForm")[0].innerHTML =`
        <h1>Update a Record</h1>
        <p  id="description">Enter the ID of the record you want to update and fill up the form field to update the record</p>
        <form>
                    <div class="label-container">
                        <label for="idName">ID: (First name and Last name)</label>
                    </div>
                    
                    <br>
                    <input class="inputDesign formInput" type="text" id="idName" name="idName" placeholder="Example: John Doe" maxLength='100'>
                    
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
                        <button type="button"  class="button" id="updateRecord" value="updateRecord" onclick="updateOneRec()">Submit</button>
                    </div><br>
                    <div class="submit-container">
                        <button type="button"  class="button" id="showRecords" value="showRecords" onclick="showAllRec()">Show All Records</button> 
                    </div><br>
                    <div class="submit-container">
                        <button type="button"  class="button" id="editRecord" value="editRecord" onclick="showEditPage()">Back</button>
                    </div>
                </form>
        `;
        addTextCounter();
    }
    //END OF SPA FUNCTIONS
    //text counter
    function addTextCounter(){
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
    }

    // CLICK BUTTON VALUES
    var btnClickValue;
    function deleteAllRec(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            var formData = {
                action:document.getElementById("deleteAll").value,
            };
            var jsonString = JSON.stringify(formData);
            sendViaAjax(jsonString);
        }
        });
        
    }

    function updateOneRec(){
        var gender = document.querySelector('input[name="gender"]:checked') ? document.querySelector('input[name="gender"]:checked').value : null;
        var formData = {
            action: document.getElementById("updateRecord").value,
            user_ID: document.getElementById("idName").value.trim(),
            user_fName: document.getElementById("fName").value.trim(),
            user_lName: document.getElementById("lName").value.trim(),
            user_address: document.getElementById("userAddress").value.trim(),
            user_gender: gender,
            user_age: parseInt(document.getElementById("userAge").value,10),
        };
        errorCheckAndSubmit(formData)
    }
    function deleteOneRec(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            var formData = {
                action: document.getElementById("deleteOne").value,
                user_ID: document.getElementById("deleteOneInp").value,
            };
            var jsonString = JSON.stringify(formData);
            sendViaAjax(jsonString);
        }
        });
    }
    function showAllRec(){
        var formData = {
            action: document.getElementById("showRecords").value,
            // user_ID: document.getElementById("fName").value,
        };
        var jsonString = JSON.stringify(formData);
        sendViaAjax(jsonString);
    }

    //alert only
    function sendViaAjax(jsonString){
        $.ajax({
            type: "POST",
            url: "Reg_Form_Array2.php",
            data: {myJson: jsonString}
        }).done(function( msg ) {
            if(msg=="deleted"){
                Swal.fire({
                    title: "Deleted!",
                    text: "All records have been deleted.",
                    icon: "success"
                });
            }else if(msg=="oneDelete"){
                Swal.fire({
                    title: "Deleted!",
                    text: "A record has been deleted",
                    icon: "success"
                });
            }else if(msg=="noID"){
                Swal.fire({
                    title: "ID Does not exist",
                    text: "The ID you entered does not exist.",
                    icon: "warning"
                });
            }
            else{
                Swal.fire({
                        // icon: "warning",
                        title: "All records",
                        html:  msg,
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
        });
    }
      
    function submitFormViaJSON(){
        //format to JSON
        var gender = document.querySelector('input[name="gender"]:checked') ? document.querySelector('input[name="gender"]:checked').value : null;
        var formData = {
            action: 'addNewRecord',
            user_fName: document.getElementById("fName").value.trim(),
            user_lName: document.getElementById("lName").value.trim(),
            user_address: document.getElementById("userAddress").value.trim(),
            user_gender: gender,
            user_age: parseInt(document.getElementById("userAge").value,10),
        };
        errorCheckAndSubmit(formData);
        
    }
    function errorCheckAndSubmit(formData){
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
                url: "Reg_Form_Array2.php", 
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
                    }//ID does not exist (update record)
                    else if(response=="noID"){
                        Swal.fire({
                            title: "ID Does not exist",
                            text: "The ID you entered does not exist.",
                            icon: "warning"
                        });
                    }//ID exist (new record)
                    else if(response=="IDExist"){
                        Swal.fire({
                            title: "ID already exist",
                            text: "The first name and last name combination you entered already exist.",
                            icon: "warning"
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
    </script>
</body>
</html>
