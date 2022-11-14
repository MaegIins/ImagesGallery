
document.getElementById("addUserBut").onclick = function () {
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

document.getElementById("cancel").onclick = function () {
    document.getElementById("popup2").style.display = "none";
}


let buttonAddImage = document.getElementById("btnAdd")




/**
 * Function that add a new input for the tags after pressing the + button
 */
buttonAddImage.addEventListener("click", function (evt) {
    let html = '<label for="img">Image Location : </label> <div id="divimg"> <input type="file" id="img" name="img" placeholder="Image Location" accept=".png, .jpg, .jpeg" required></div><label for="Tags">Tag of the image (only one): </label><input type="text" id="tags" name="tag" placeholder="Tag" required>'
    document.getElementById("moreTags").insertAdjacentHTML("afterend", html)

})


/**
 * Function that add a new input for the users after pressing the + button
 */
document.getElementById("btnAdd").onclick = function (evt) {
    console.log("click")
    let html = '<label for="newuser" id="labelUser">Add a new user : </label> <div id="divuser"> <input type="text" id="newuser" name="user[]" placeholder="New User" required></div>'
    document.getElementById("moreUser").insertAdjacentHTML("afterend", html)
}