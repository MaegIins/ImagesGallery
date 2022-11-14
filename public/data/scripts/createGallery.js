console.log("script chargé")

let buttonAddImage = document.getElementById("btAdd")




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
document.getElementById("btnplus").onclick = function (evt) {
    console.log("click")
    let html = '<label for="newuser" id="labelUser">Add a new user : </label> <div id="divuser"> <input type="text" id="newuser" name="user[]" placeholder="New User" required></div>'
    document.getElementById("moreUser").insertAdjacentHTML("afterend", html)
}

//ajoute add user quand le bouton radio priavte est select
document.getElementById("priv").addEventListener("click", function (evt) {
    document.getElementById("btnplus").hidden = false;
    document.getElementById("newuser").hidden = false;
    document.getElementById("labelUser").hidden = false
})
//rend le menu add user invisible quand c'est en publice
document.getElementById("publ").addEventListener("click", function (evt) {

    document.getElementById("newuser").hidden = true;
    document.getElementById("btnplus").hidden = true;
    document.getElementById("labelUser").hidden = true;
})


