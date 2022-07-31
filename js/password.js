//-------------------------------------------------[CONFIRM]------------------------------------------
function checkEqual()
{
    var pass = document.getElementById("pass");
    var conf = document.getElementById("confirm");

    if(pass.value !== conf.value)
    {
        document.getElementById("confirm_error").innerHTML = 'Password and its confirmation do not match';
        document.getElementById("confirm_error").style.color = "red";
    }
    else
    {
        document.getElementById("confirm_error").innerHTML = '';
        document.getElementById("confirm_error").style.color = "var(--bs-body-color)";
    }
}

// When the user clicks on the password field, show the message box
function boxOn() {
    document.getElementById("message").style.display = "block";
}
  
// When the user clicks outside of the password field, hide the message box
function boxOff() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
function startType() { 
    var myInput = document.getElementById("pass");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");
  
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(myInput.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(myInput.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(myInput.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

    // Validate length
    if(myInput.value.length >= 8 && myInput.value.length <= 16) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
}
