console.log("script chargé")

let buttonAddImage = document.getElementById("btAdd")
let tags = document.getElementById("moreTags")
let private = document.getElementById("priv")
let public = document.getElementById("publ")
let adduser = document.getElementById("moreUser")
let add = document.getElementById("newuser")
let btnplus = document.getElementById("btnplus")
let label = document.getElementById("labelUser")
let buttonAddUser = document.getElementById("btnplus");





buttonAddImage.addEventListener("click", function (evt) {
    let html = '<label for="img">Image Location : </label> <div id="divimg"> <input type="file" id="img" name="img" placeholder="Image Location"><input type="button" value="+" name="add_img" id="btAdd"></div><label for="Tags">Tag of the image (only one): </label><input type="text" id="tags" name="tag" placeholder="Tag">'
    tags.insertAdjacentHTML("afterend", html)
})

buttonAddUser.addEventListener("click", function (evt) {
    let html = '<label for="newuser" id="labelUser">Add a new user : </label> <div id="divuser"> <input type="text" id="newuser" name="user" placeholder="New User"> <input type="button" id="btnplus"value="+" name="add_username"> </div>'
    tags.insertAdjacentHTML("afterend", html)
})

//ajoute add user quand le bouton radio priavte est select 
private.addEventListener("click", function (evt) {
    btnplus.hidden = false;
    add.hidden = false;
    label.hidden = false
})
//rend le menu add user invisible quand c'est en public
public.addEventListener("click", function (evt) {

    add.hidden = true;
    btnplus.hidden = true;
    label.hidden = true;
})