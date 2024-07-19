function showImage(event) {
  var uploadInput = document.getElementById("uploadImage");
  var image = document.getElementById("uploadedImage");
  var uploadIcon = document.querySelector(".upload-icon");
  var file = event.target.files[0];

  if (file) {
    image.src = URL.createObjectURL(file);
    image.style.display = "block";
    uploadIcon.style.display = "none";
  } else {
    image.style.display = "none";
    uploadIcon.style.display = "block";
  }
}

function resetForm() {
  var form = document.getElementById("registrationForm");
  form.reset();

  // Reset image preview
  var image = document.getElementById("uploadedImage");
  var uploadIcon = document.querySelector(".upload-icon");
  var uploadInput = document.getElementById("uploadImage");

  uploadInput.value = "";
  image.src = "#";
  image.style.display = "none";
  uploadIcon.style.display = "block";
}
