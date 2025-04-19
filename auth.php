<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/auth.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/1ov5HvFqLWVnYtUzgD5xj6eY+Oz7+vR9LRP4z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    body {
        background: linear-gradient(to bottom, #000060 0%, #2971ff 100%);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
        
    }

    .auth-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        background-color: transparent;
        
    }

    .logo img {
        max-width: 150px; /* Adjust logo size */
        margin-bottom: 20px;
    }

    .form-container {
    width: 100%;
    max-width: 400px; /* Restrict the form width */
    background-color: rgba(255, 255, 255, 0.85); /* Semi-transparent white background for contrast */
    border: 1px solid rgba(0, 0, 0, 0.2); /* Subtle border for more definition */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15); /* Slightly stronger shadow for more depth */
    padding: 20px; /* Add padding for content spacing */
}


    .card-body {
        padding: 0;
        background-color: transparent;
        
    }

    .form-floating {
        margin-bottom: 15px;
    }

    .btn-login {
        background-color: #007bff;
        border: none;
        padding: 10px;
    }

    .btn-login:hover {
        background-color: #0056b3;
    }

    .text-center span a {
        color: #007bff;
    }

    .text-center span a:hover {
        text-decoration: underline;
    }
    
</style>
<body>
    <div class="auth-container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="image/dwcl-logo.png" alt="Logo" class="img-fluid">
        </div>

        <!-- Form Section -->
        <div class="form-container">
            <div class="card-body">
                <!-- Sign In Form -->
                <div id="signInForm">
                    <h5 class="card-title text-center mb-4 fw-light fs-5">Sign In</h5>
                    <form method="post" action="backend/sign-in-user.php">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="signInEmail" name="email" placeholder="name@example.com">
                            <label for="signInEmail">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="signInPassword" name="password" placeholder="Password">
                            <label for="signInPassword">Password</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                            <label class="form-check-label" for="rememberPasswordCheck">
                                Remember password
                            </label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign In</button>
                        </div>
                        <div class="text-center mt-3">
                            <span>Don't have an account? <a href="#" onclick="showSignUpForm()">Sign Up</a></span>
                        </div>
                    </form>
                </div>

                <!-- Sign Up Form -->
                <div id="signUpForm" style="display: none;">
                    <h5 class="card-title text-center mb-4 fw-light fs-5">Sign Up</h5>
                    <form method="post" action="backend/sign-up-query.php">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="signUpEmail" name="email" placeholder="name@example.com" required>
                            <label for="signUpEmail">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="signUpPassword" name="password" placeholder="Password" required>
                            <label for="signUpPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                            <label for="confirmPassword">Confirm Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="userTypeSelect" name="userType" aria-label="User Type" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="supply_manager">Supply Manager</option>
                            </select>
                            <label for="userTypeSelect">Select User Type</label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign Up</button>
                        </div>
                        <div class="text-center mt-3">
                            <span>Already have an account? <a href="#" onclick="showSignInForm()">Sign In</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showSignUpForm() {
            document.getElementById('signInForm').style.display = 'none';
            document.getElementById('signUpForm').style.display = 'block';
        }

        function showSignInForm() {
            document.getElementById('signUpForm').style.display = 'none';
            document.getElementById('signInForm').style.display = 'block';
        }
    </script>
</body>
</html>
