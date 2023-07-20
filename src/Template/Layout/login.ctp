<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RabbitPro - Easy management of your rabbitory</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an application that you can use to manage your rabbitory easily">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

<?php echo $this->Html->css(array('main.d810cf0ae7f39f28f336')); ?>

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100 bg-plum-plate bg-animation">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="mx-auto app-login-box col-md-8">
                        <div class="app-logo-inverse mx-auto mb-3"></div>
                        <div class="modal-dialog w-100 mx-auto">
                            <center><?php echo $this->Flash->render(); ?></center>
                            <?php echo $this->fetch('content'); ?>
                            
                        </div>
                        <div class="text-center text-white opacity-8 mt-3">Copyright © RABBIT PRO <?php echo date('Y'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<?php echo $this->Html->script(array('main.d810cf0ae7f39f28f336','jquery.blockUI','custom')); ?>
</body>


</html>