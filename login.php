<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #86B817, #5a8e0f); /* Gradient using #86B817 */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-container {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-img-card {
            width: 100px;
            margin: 0 auto 20px;
            display: block;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="img/htl.png" alt="Hotel Logo"/>
        
        <div class="result">
            <?php
            if (isset($_GET['empty'])){
                echo '<div class="alert alert-danger">Enter Username or Password</div>';
            }elseif (isset($_GET['loginE'])){
                echo '<div class="alert alert-danger">Username or Password Don\'t Match</div>';
            } ?>
        </div>

        <form class="form-signin" action="ajax.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Username or Email</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Enter Username or Email" required>
                <div class="invalid-feedback">Please enter your username or email.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                <div class="invalid-feedback">Please enter your password.</div>
            </div>

            <button type="submit" name="login" class="btn btn-success btn-block w-100">Sign In</button>
        </form>
    </div>
</div>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>

<!-- Optional JavaScript for form validation -->
<script>
    // Example of Bootstrap 5 form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.form-signin')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
</body>
</html>
