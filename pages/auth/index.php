<!DOCTYPE html>
<html lang="en">
<?php require_once PARTIALS_PATH . '/header.php'; ?>

<link rel="stylesheet" href="<?php getCSSFile('login.css') ?>">

<body id="login-body" style='background-image: url("<?php getImagePath('prima-bg.jpg') ?>");'>
    <div class="container login">
        <div class="login-container">
            <div class="login-box">
                <img src="<?php getImagePath('prima-logo.png') ?>"
                    alt="Logo" class="img-responsive center-block">
                <h4 class="text-center" id="systemLabel"><?php echo SYSTEM_NAME ?></h4>
                <form id="loginForm">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-lg-12 form-element">
                                <label for="id">ID</label>
                                <input type="text" id="id" class="form-control"
                                    placeholder="Enter your  ID">
                            </div>

                            <div class="col-lg-12 form-element">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="Enter your password">
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary btn-block" id="loginBtn">Log in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php getJSHelper('errorFunction.js') ?>"></script>
    <script type="text/javascript" src="<?php getAjaxPath('auth/loginUser.js') ?>"></script>
</body>

</html>