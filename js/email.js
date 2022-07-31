function checkMail(url)
{
    let usermail = document.getElementById("email").value;
    console.log(usermail);

    return fetch(url, {
        method: 'post',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: 'email=' +usermail,
    }).then(function(response){
        if(response.status !== 200)
        {
            console.log("There was a problem, status cose: " + response.status);
            return;
        }
        //Get the text from the response
        return response.text();
    }).then(function(result){
        if(result == 'KO')
        {
            document.getElementById("email_error").innerHTML = 'e-mail already used, try a different one';
            document.getElementById("email_error").style.color = "red";
        }
        else
        {
            document.getElementById("email_error").innerHTML = '';
            document.getElementById("email_error").style.color = "var(--bs-body-color)";
        }
    });
}