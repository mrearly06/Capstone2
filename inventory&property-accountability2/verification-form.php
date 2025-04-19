<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Account Verification</h2>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body border border-2">
                        <form id="verificationForm" action="backend/verify-account.php" method="post">
                            <input type="hidden" name="email" id="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                            <div class="mb-3">
                                <label for="verificationCode" class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="verificationCode" name="verificationCode" required placeholder="Enter the verification code">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Verify</button>
                        </form>
                        <div id="verificationMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
