<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 27-11-17
 * Time: 23:54
 */

$usuario = $this->session->userdata('usuario');
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url();?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="<?=base_url('assets/img/logo-aicapitals-100.png')?>" class="img-responsive"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="<?=base_url('assets/img/logo-AICapitals.png')?>" class="img-responsive"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Cambiar Navegación</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if($usuario['sexo'] == 'M')
                        {
                            ?><img src="<?=base_url('assets')?>/adminlte/dist/img/user_male.png" class="user-image" alt="User Image"><?php
                        }else{
                            ?>
                            <img src="<?=base_url('assets')?>/adminlte/dist/img/user_female.png" class="user-image" alt="User Image">
                            <?php
                        }
                        ?>
                        <!--<img src="<?=base_url();?>adminlte//dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                        <span class="hidden-xs"><?=$usuario['username']?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                            if($usuario['sexo'] == 'M')
                            {
                              ?><img src="<?=base_url('assets')?>/adminlte/dist/img/user_male.png" class="img-circle" alt="User Image"><?php
                            }else{
                                ?>
                                <img src="<?=base_url('assets')?>/adminlte/dist/img/user_female.png" class="img-circle" alt="User Image">
                            <?php
                            }
                            ?>

                            <p>
                                <?=ucwords($usuario['first_name'].' '.$usuario['last_name']);?>
                                <small><?=$usuario['cargo'];?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        <!--</li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!--
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            -->
                            <div class="pull-right">
                                <a href="<?=base_url('login/logout')?>" class="btn btn-default btn-flat">Desconectar</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <!--
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                -->
            </ul>
        </div>
    </nav>
</header>
