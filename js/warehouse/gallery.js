function  gallery_view() {
    var req = new XMLHttpRequest();
    req.open("POST", "/index.php/warehouse/gallery", true);
    req.onreadystatechange = function () {
        if (this.readyState == 4) {
            /*console.log(this.response);*/
            var data = JSON.parse(this.response);

            /*console.log(data);*/
            document.getElementsByClassName("main-body")[0].innerHTML="";
            for (var arr = 0 ; arr < data.length ; arr++) {
                var div = document.createElement("div");
                /*console.log(data[arr].f_name);*/
                div.setAttribute("class", "image");
                div.onclick = function () {
                    this.classList.toggle("image-selected");
                    console.log(this);
                    if (this.getAttribute("class").indexOf("image-magnified") != -1) {
                        this.classList.remove("image-magnified");
                    }
                }
                div.ondblclick = function () {
                    this.classList.add("image-magnified");
                }
                var img = document.createElement("img");
                var ext = data[arr].f_name.split(".")[1];
                if (ext === "jpg"||ext === "png"){
                    img.src = "../download/"+data[arr].f_micro;
                }
                else{
                    img.src = "../public/img/folder.gif";
                }
                div.appendChild(img);
                document.getElementsByClassName("main-body")[0].appendChild(div);
            }

        }
    }

    req.send();
}