<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="icon" class="image/x-icon" href="./images/logo.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../static/css/style.css">
</head>

<body>
    <div class="brand-container">
        <a class="logo-brand" href="./admin.php">
            <img class="logo" src="./images/logo.png" alt="logo" />
        </a>
        <button class="logout_btn">LogOut <i class="fa-solid fa-right-from-bracket"></i></button>
    </div>

    <div class="attendance_topic">
        <h1>STUDENT REGISTRATION PORTAL</h1>
    </div>

    <div class="details_container">
        <section class="h-100">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card card-registration my-4">
                            <div class="row g-0">
                                <div class="col-xl-10 mx-auto">
                                    <div class="card-body p-md-5 text-black">
                                        <div class="row align-items-start">
                                            <div class="col-md-4 mb-2 ">
                                                <div class="name-form-outline">
                                                    <input type="text" id="name"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="name" name="firstname">First
                                                        name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-0">
                                                <div class="name-form-outline">
                                                    <input type="text" id="name"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="name" name="lastname">Last
                                                        name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2 position-relative">
                                                <div class="upload-container">
                                                    <input type="file" id="uploadImage"
                                                        class="form-control form-control-lg file-input"
                                                        name="profile_image" accept="image/*"
                                                        onchange="showImage(event)" />
                                                    <label class="custom-upload" for="uploadImage">
                                                        <img src="https://via.placeholder.com/150" alt="Upload Icon"
                                                            class="upload-icon" />
                                                    </label>
                                                    <img id="uploadedImage" src="#" alt="Uploaded Image"
                                                        class="uploaded-image" />
                                                </div>
                                                <figcaption>Upload Image</figcaption>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 mb-0">
                                                <div class="address-form-outline">
                                                    <input type="text" id="address"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="address"
                                                        name="address">Address</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <div class="form-outline">
                                                    <input type="text" id="fathers_name"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="fathers_name"
                                                        name="fathers_name">Father's
                                                        name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-outline">
                                                    <input type="text" id="mothers_name"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="mothers_name"
                                                        name="mothers_name">Mother's
                                                        name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-4">
                                            <div class="col-md-6">
                                                <h6 class="mb-3 me-2">Gender:</h6>
                                                <div class="form-check form-check-inline mb-0 me-5 ">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineRadioOptions" id="femaleGender" value="option1" />
                                                    <label class="form-check-label" for="femaleGender" name="female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0 me-4">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineRadioOptions" id="maleGender" value="option2" />
                                                    <label class="form-check-label" for="maleGender" name="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineRadioOptions" id="otherGender" value="option3" />
                                                    <label class="form-check-label" for="otherGender" name="other">Other</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="dob"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="dob" name="dob">Date of Birth</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-start mb-4">
                                            <div class="col-md-6">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="faculty"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="faculty" name="faculty">Faculty</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="email"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="email" name="email" >Email ID</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">
                                            <button type="button" class="btn btn-light btn-lg mx-2">Reset all</button>
                                            <button type="button" class="btn btn-warning btn-lg ms-2">Submit
                                                form</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function showImage(event) {
            var uploadInput = document.getElementById('uploadImage');
            var image = document.getElementById('uploadedImage');
            var uploadIcon = document.querySelector('.upload-icon');
            var file = event.target.files[0];

            if (file) {
                image.src = URL.createObjectURL(file);
                image.style.display = 'block';
                uploadIcon.style.display = 'none';
            } else {
                image.style.display = 'none';
                uploadIcon.style.display = 'block';
            }
        }
    </script>
</body>

</html>