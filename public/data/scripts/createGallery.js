console.log("script chargé")

let buttonAddImage = document.getElementById("btAdd")
let tags = document.getElementById("moreTags")
let privatee = document.getElementById("priv")
let publice = document.getElementById("publ")
let adduser = document.getElementById("moreUser")
let add = document.getElementById("newuser")
let btnplus = document.getElementById("btnplus")
let label = document.getElementById("labelUser")
let buttonAddUser = document.getElementById("btnplus");


/**
 * Function that add a new input for the tags after pressing the + button
 */
buttonAddImage.addEventListener("click", function (evt) {
    let html = '<label for="img">Image Location : </label> <div id="divimg"> <input type="file" id="img" name="img" placeholder="Image Location" accept=".png, .jpg, .jpeg" required></div><label for="Tags">Tag of the image (only one): </label><input type="text" id="tags" name="tag" placeholder="Tag" required>'
    tags.insertAdjacentHTML("afterend", html)

})


/**
 * Function that add a new input for the users after pressing the + button
 */
buttonAddUser.addEventListener("click", function (evt) {
    console.log("click")
    let html = '<label for="newuser" id="labelUser">Add a new user : </label> <div id="divuser"> <input type="text" id="newuser" name="user[]" placeholder="New User" required></div>'
    adduser.insertAdjacentHTML("afterend", html)
})

//ajoute add user quand le bouton radio priavte est select 
privatee.addEventListener("click", function (evt) {
    btnplus.hidden = false;
    add.hidden = false;
    label.hidden = false
})
//rend le menu add user invisible quand c'est en publice
publice.addEventListener("click", function (evt) {

    add.hidden = true;
    btnplus.hidden = true;
    label.hidden = true;
})


