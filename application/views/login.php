<div class="login-box">
    <div class="login-logo">
        <a href="<?=base_url()?>"><b>REPORTES</b> | AiCapitals </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Ingrese sus credenciales para iniciar sesión.</p>
        <?php echo $this->session->flashdata('message');?>
        <?php echo form_open('login/logon',array('id'=>'form_login','method'=>'post'));?>
            <input type="hidden" value="https://intranet.aicapitals.cl/ingresar.json/" id="remote_login" />
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="usuario@aicapitals.com" name="username" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_logon" id="btn_logon">Iniciar Sesión</button>
                </div>
                <!-- /.col -->
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <img src="<?=base_url('assets/img')?>/logo-AICapitals.png" >
                </div>
            </div>
        <?php echo form_close();?>
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->