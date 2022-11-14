console.log("script chargé")

let buttonAddImage = document.getElementById("btAdd")
let tags = document.getElementById("moreTags")
let private = document.getElementById("priv")
let public = document.getElementById("publ")
let textUser = document.getElementById("newuser")
let btnplus = document.getElementById("btnplus")
let label = document.getElementById("labelUser")



buttonAddImage.addEventListener("click", function(evt){
    let html = '<label for="img">Image Location : </label> <div id="divimg"> <input type="file" id="img" name="img" placeholder="Image Location"><input type="button" value="+" name="add_img" id="btAdd"></div><label for="Tags">Tag of the image (only one): </label><input type="text" id="tags" name="tag" placeholder="Tag">'
    tags.innerHTML += html;
;    console.log("sss")
})


private.addEventListener("click", function(evt) {
    textUser.hidden = false;
    btnplus.hidden = false;
    label.hidden = false;
})

public.addEventListener("click", function(evt) {
    textUser.hidden = true;
    btnplus.hidden = true;
    label.hidden = true;
})