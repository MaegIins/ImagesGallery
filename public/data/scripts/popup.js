document.getElementById("loginBut").onclick = function() {
    document.getElementById("popup2").style.display = "none";
    document.getElementById("popup").style.display = "block";
}

document.getElementById("cancelLogin").onclick = function () {
    document.getElementById("popup").style.display = "none";
}

document.getElementById("signup").onclick = function () {
    document.getElementById("popup").style.display = "none";
    document.getElementById("popup2").style.display = "block";
}

document.getElementById("cancelSignup").onclick = function () {
    document.getElementById("popup2").style.display = "none";
}


if (document.getElementById("errorLog").value !== '') {
    document.getElementById("popup").style.display = "block";
}

if (document.getElementById("errorSign").value !== '') {
    document.getElementById("popup2").style.display = "block";
}


