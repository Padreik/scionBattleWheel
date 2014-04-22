var imageToCrop = $("#image");
var imagePreview = $("#imagePreview");
var iconPreview = $("#iconPreview");

/**
 * Display an image from an upload input before sending it
 * @param input File input where we insert the image
 * @param preview Img containing image preview
 */
function readURL(input, preview) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

if (imageToCrop.val().length) {
    readURL(imageToCrop);
}

imageToCrop.change(function(){
    readURL(this, imagePreview);
    readURL(this, iconPreview);
});

/**
 * Display name in preview
 */
$('#name').change(function(){
    $('.iconText').text(this.value);
});

/**
 * Start imgAreaSelect on the uploaded image
 */
imagePreview.imgAreaSelect({
    handles: true,
    aspectRatio: '1:1',
    onSelectEnd: function (img, selection) {
        $('input[name="x1"]').val(selection.x1);
        $('input[name="y1"]').val(selection.y1);
        $('input[name="x2"]').val(selection.x2);
        $('input[name="y2"]').val(selection.y2);            
    },
    onSelectChange: preview
});

function preview(img, selection) {
    var scaleX = 50 / (selection.width || 1);
    var scaleY = 50 / (selection.height || 1);
  
    iconPreview.css({
        width: Math.round(scaleX * imagePreview.width()) + 'px',
        height: Math.round(scaleY * imagePreview.height()) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
    $('.iconAndTextHolder').css('visibility', 'visible');
}