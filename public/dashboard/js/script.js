
    let imgFiles = document.querySelectorAll('.image-resize');
    imgFiles.forEach(imgFile => {
        var reader = new FileReader();
        reader.onload = function(e){
            var img = document.createElement("img");
            img.onload = function (event) {
                // Dynamically create a canvas element
                var canvas = document.createElement("canvas");

                // var canvas = document.getElementById("canvas");
                var ctx = canvas.getContext("2d");

                // Actual resizing
                ctx.drawImage(img, 0, 0, 300, 300);

                // Show resized image in preview element
                var dataurl = canvas.toDataURL(imgFile.type);
                document.getElementById("preview").src = dataurl;
            }
            img.src = e.target.result;
        }
        reader.readAsDataURL(imgFile);
    });
    