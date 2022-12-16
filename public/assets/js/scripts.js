window.addEventListener('load', () => {
    const loader = document.querySelector('.loader');
    loader.classList.add('loader-hidden');
});

// LOADFILE PICTURE USER
var loadFile = function (event) {
    var image = document.getElementById("output");
    image.src = URL.createObjectURL(event.target.files[0]);
    var changeButton = document.getElementById('changeImage');
    changeButton.style.color = 'gray';
    changeButton.style.borderLeft = '3px solid green';
    changeButton.style.borderRight = '3px solid green';
    changeButton.style.borderBottom = '4px solid green';
};

// DELETE ELEMENT
let deletesElement = document.querySelectorAll('.deleteLinkElement');
deletesElement.forEach(deletes => {
    let url = deletes.dataset.url;
    let typeElement = deletes.dataset.type;
    let element = deletes.dataset.name;
    deletes.addEventListener("click", () => {
        document.getElementById('deleteFormElement').action = url;
        document.getElementById('deleteElementType').innerHTML = typeElement;
        document.getElementById('deleteElementTypeInput').setAttribute('value', 'Delete ' + typeElement);
        document.getElementById('deleteElementName').innerHTML = element;
    });
});

// IMAGES UPLOAD REVIEW
jQuery(document).ready(function () {
  ImgUpload();
});

var cont = 0;
function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];
  var imgs = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {
        if (!imgs.includes(f.name)) {
          imgs.push(f.name);
          if (!f.type.match('image.*')) {
            return;
          }
  
          if (imgArray.length > maxLength) {
            return false;
          } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i] !== undefined) {
                len++;
              }
            }
            if (len > maxLength) {
              return false;
            } else {
              imgArray.push(f);
  
              var reader = new FileReader();
              reader.onload = function (e) {
                if (imgWrap.children().length < 8) {
                  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                  imgWrap.append(html);
                  iterator++;
                }
              }
              reader.readAsDataURL(f);
            }
          }
        }
      });
    });
  });
  
  $('.upload__thumbnail').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              imgWrap.empty();
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        imgs.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}


$('#createForm').on("click", () => {
  if($('#thumbnail_wrap').children().length == 0) {
    $('#thumbnail_input').val('');
  }
  if($('#images_wrap').children().length == 0) {
    $('#images_input').val('');
  }
  if(tinymce.get("messageReview").getContent()) {
    $('#hidden_message').removeAttr('required');
  } else {
    $('#hidden_message').attr('required', 'required');
  }
});


// THUMBNAIL
$('#thumbnail_label').on('click', () => {
  $('#thumbnail_input').trigger('click'); 
});