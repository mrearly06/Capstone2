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
<body class="bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <!-- Sign In Form -->
                        <div id="signInForm">
                            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
                            <form method="post" action="backend/sign-in-user.php">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="signInEmail" name="email" placeholder="name@example.com">
                                    <label for="signInEmail">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="signInPassword"  name="password" placeholder="Password">
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
                                <hr class="my-4">
                       <!--          <div class="d-grid mb-2">
                                    <button type="button" class="btn btn-danger btn-lg btn-google"><i class="fab fa-google"></i> Sign in with Google</button>
                                </div> -->
                            </form>
                        </div>

                        <!-- Sign Up Form -->
                       <!-- Sign Up Form -->
                        <div id="signUpForm" style="display: none;">
                            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign Up</h5>
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
                                    <span>Don't have an account? <a href="#" onclick="showSignInForm()">Sign In</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
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
