
$(".imageAvatarUpload").change(function () {
    imageAvatarPreview($(this), this);
});
function imageAvatarPreview(element, input) {
    if (input.files && input.files[0]) {
        if ($('#' + element.attr('id') + '_preview').length > 0) {
            $('#' + element.attr('id') + '_preview').closest(".image_preview").remove();
        }
        var reader = new FileReader();
        var imgTemp = document.createElement("img");

        reader.onload = function (e) {
            imgTemp.src = e.target.result;
            imgTemp.onload = function () {
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(imgTemp, 0, 0);
                var MAX_WIDTH = 200;
                var MAX_HEIGHT = 200;
                var width = imgTemp.width;
                var height = imgTemp.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(imgTemp, 0, 0, width, height);
                if(hasAlpha (ctx, canvas)){
                    dataurl = canvas.toDataURL("image/png");
                } else {
                    dataurl = canvas.toDataURL("image/jpeg");
                }
                var img = $('<img>');
                img.attr('src', dataurl);
                $('#imageData').val(dataurl);
                img.attr('id', element.attr('id') + '_preview');
                element.after('<div class="image_preview mt-1">' + element.data('selected') + '<br>' + img[0].outerHTML + '</div>');

            } // img.onload
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        if ($('#' + element.attr('id') + '_preview').length > 0) {
            $('#' + element.attr('id') + '_preview').closest(".image_preview").remove();
        }
    }
}

function hasAlpha (context, canvas) {
    var data = context.getImageData(0, 0, canvas.width, canvas.height).data,
        hasAlphaPixels = false;
    for (var i = 3, n = data.length; i < n; i+=4) {
        if (data[i] < 255) {
            hasAlphaPixels = true;
            break;
        }
    }
    return hasAlphaPixels;
}
