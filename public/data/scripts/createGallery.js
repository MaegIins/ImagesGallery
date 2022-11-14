console.log("script chargé")

let buttonAddImage = document.getElementById("btAdd")
let tags = document.getElementById("moreTags")



buttonAddImage.addEventListener("click", function(evt){
    let html = '<label for="img">Image Location : </label> <div id="divimg"> <input type="file" id="img" name="img" placeholder="Image Location"><input type="button" value="+" name="add_img" id="btAdd"></div><label for="Tags">Tag of the image (only one): </label><input type="text" id="tags" name="tag" placeholder="Tag">'
    tags.innerHTML += html;
;    console.log("sss")
})