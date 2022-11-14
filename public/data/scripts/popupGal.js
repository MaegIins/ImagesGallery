
document.getElementById("addUserBut").addEventListener.onclick = function () {
    document.getElementById("popup2").style.display = "none";
    document.getElementById("popup").style.display = "block";
}

document.getElementById("cancelLogin").onclick = function () {
    document.getElementById("popup").style.display = "none";
}

document.getElementById("addImgBut").onclick = function () {
    document.getElementById("popup").style.display = "none";
    document.getElementById("popup2").style.display = "block";
}

document.getElementById("cancelSignup").onclick = function () {
    document.getElementById("popup2").style.display = "none";
}
