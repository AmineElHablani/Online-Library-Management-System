
function verification(){
    let password= document.getElementById('pwd')
    let passwordConfirmation= document.getElementById('pwdConfirmation')
    let Message = document.getElementById("pawVerification")
    if(password.value !== passwordConfirmation.value){
        alert("passwords are incompatible.") 
        return false;
        //Message.innerText="passwords are incompatible."  
    }else{
        return true;
    }
}

function show(){
    let password= document.getElementById('pwd')
    let passwordConfirmation= document.getElementById('pwdConfirmation')
    console.log(password.type)
    if(password.type === "text"){
        password.type="password"
        passwordConfirmation.type="password"
    }else{
        password.type="text"
        passwordConfirmation.type="text"
    }

}

function duplicate(){
    let formParent = document.getElementById("parentForm")

    formParent.innerHTML += `
    <div class="Members">
    <hr size="50">
    <h1 class="text-center" style="color:green">Group member</h1>
    <div class="row">
    <div class="col">
        <label class="form-label">First name</label>
        <input type="text" name="firstName" class="form-control" required="True" >
        <span id="verificationFN" ></span>
    </div>
    <div class="col">
        <label class="form-label">Last name</label>
        <input type="text" name="lastName" class="form-control" required="True">
        <span id="verificationLN" ></span>

    </div>
    </div>
    <div class="mb-3">
    <label class="form-label">Email address</label>
    <input type="email" name="Email" class="form-control" aria-describedby="emailHelp" required="True">
    <span id="verificationEmail" ></span>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
    <label for="pwd" class="form-label">Password</label>
    <input type="password" name="PWD" class="form-control" id="pwd" required>
    <span id="verificationPwd" ></span>

  </div>
  <div class="mb-3">
      <label for="pwdConfirmation" class="form-label">Password Confirmation</label>
      <input type="password" name="pwdConfirmation" class="form-control" id="pwdConfirmation" required>
      <span id="verificationPwdV" ></span>
      <div class="invalid-feedback" id="pwdVerification">
      </div>
  </div>
    <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="showPassword" onclick="show();">
    <label class="form-check-label" for="showPassword">Show Password</label>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="Address" class="form-control" required>
        <span id="verificationAddress" ></span>

    </div>

    <div class="row">
        <div class="col">
            <label  class="form-label">Country</label>
            <select name="Country" class="form-control" required>
            <option selected>Choose...</option>
            <option>...</option>
            </select>
            <span id="verificationCountry" ></span>

        </div>

        <div class="col">
            <label class="form-label">City</label>
            <input type="text" name="City" class="form-control" required>
            <span id="verificationCity" ></span>

        </div>

        <div class="col">
            <label class="form-label">Zip</label>
            <input type="text" name="Zip" class="form-control" required>
            <span id="verificationZip" ></span>

        </div>
        </div>

        <div class="mb-3 pt-3">
            <label class="form-label">Image</label>
            <input type="file" accept="image/*" class="form-control" required>
            <span id="verificationImage" ></span>

        </div>
        <div class="mb-3 pt-3">
        <button type="button" class="btn btn-primary" onclick="deleteForm()">Delete Last Form</button>
        </div>

    </div>

    `
}

function deleteForm(){
    // Select all div elements with the class 'yourClassName'
    let formParent = document.getElementById("parentForm")
    let members = document.getElementsByClassName('Members');


    // Remove the last div element
    formParent.removeChild(formParent.lastChild);


    console.log(formParent)
}


function displaySelectedImage(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            selectedImage.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}


function camera(){

    // Configure a few settings and attach camera 250x187
	 Webcam.set({
        width: 350,
        height: 287,
        image_format: 'jpeg',
        jpeg_quality: 90
       });	 
       Webcam.attach( '#my_camera');
    let snapdiv = document.getElementById("takeSnap");
    snapdiv.style = "";
    //snapdiv.innerText = ""
    //snapdiv.className = 
    
    }
    
    
/*====================================================================== */
    
function take_snapshot() {
    // play sound effect
    //shutter.play();
    // take snapshot and get image data
    Webcam.snap( function(data_uri) {
    // display results in page
    document.getElementById('userFace').innerHTML = 
    '<img  id="selectedAvatar" class="rounded-circle after_capture_frame" src="'+data_uri+'" style="width: 200px; height: 200px; object-fit: cover;" alt="example placeholder" />';

    $("#captured_image_data").val(data_uri);
    });
    //let cameraDiv = document.getElementById('my_camera');
    //cameraDiv.innerHTML=""
    Webcam.reset();

}



/*=========================================================================================== */


function saveSnap(){
    var base64data = $("#captured_image_data").val();
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "capture_image_upload.php",
            data: {image: base64data},
            success: function(data) { 
                alert(data);
            }
        });
}


function saveSnapVerificationLevel2(){
    var base64data = $("#captured_image_data").val();
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "capture_image_upload.php",
            data: {image: base64data},
            success: function(data) { 
                alert(data);
            }
        });
}



function fullSaveSnap(){
    let 
}




//input image  verification
function inputImage(){
    let imageSelect = document.getElementById("customFile2").value;
    let imageCamera = document.getElementById("captured_image_data").value;
    let verifImg = document.getElementById("chooseImage")
    let imageValue = document.getElementById("imageValue")
    

    if(imageCamera.trim() !=""){
        verifImg.value="camera"
        //var base64data = $("#captured_image_data").val();
        //imageValue.value = base64data;
    }else if (imageSelect == ""){
        alert("Please select an image before submitting the form.")
        return false;
    }
    return true;
    //console.log(imageValue.value)
}

//face verification 




function multiVerifications(){
    let form = document.getElementById("form")
    if((verification() == false) || (inputImage() == false)){
        form.setAttribute("onsubmit", "return false;");
    }else{
        form.setAttribute("onsubmit", "");
    }
    //existance();
}

function existance(){

    let im = document.getElementById("captured_image_data")
    let im2 = document.getElementById("customFile2")
    //console.log(im.value)
    console.log("heelloo")
    console.log("value"+im.value)
    console.log("value"+im2.value)
}



