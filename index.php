<!DOCTYPE html>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-validate.min.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>
    <body>
    	<?php session_start();?>
        <div class="same-block login-registration" id="login_register_container">
            <div class="preloader" id="preloader_login_register">
                <div class="page-loader-circle"></div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" id="login" onclick="<?php echo (isset($_SESSION['user_id'])?'logout()':'')?>"><?php echo (isset($_SESSION['user_id'])?'Logout':'Login')?></button>
                <button type="button" class="btn btn-primary" id="registration" <?php echo (isset($_SESSION['user_id'])?'disabled':'')?>>Registration</button>
                <button type="button" class="btn btn-primary" id="hide" <?php echo (isset($_SESSION['user_id'])?'disabled':'')?>>Hide</button>
            </div>
            <form id="login_registration" method="POST" enctype="multipart/form-data" name="login_registration">
            	<div class="alert alert-danger" id="login_register_error" style="display: none;"></div>
            	<div class="alert alert-success" id="login_register_success" style="display: none;"></div>
                <div id="login_register"></div>
            </form>
        </div>
        <div id="content">
        </div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="inputGroupPrepend" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="form" method="POST" enctype="multipart/form-data" name="form">
                        <div class="modal-header">
                            <h3>Add TODO list</h3>
                        </div>
                        <div class="modal-body" id="block_for_modal">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="send" data-dismiss="">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>