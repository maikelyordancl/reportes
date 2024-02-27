<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 27-11-17
 * Time: 23:55
 */
$usuario = $this->session->userdata('usuario');
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
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
            </div>
            <div class="pull-left info">
                <p><?=character_limiter($usuario['username'], 20, '...');?></p>
                <p><?=character_limiter($usuario['cargo'], 20, '...');?></p>
                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>
        <!-- search form -->
        <!--
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENÚ PRINCIPAL</li>
            <li class=" active">
                <a href="<?=base_url('/dashboard')?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Asociados</span>
                    <span class="pull-right-container">
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('clientes/lista_global')?>"><i class="fa fa-circle-o"></i> Clientes Global</a></li>
                    <li><a href="<?=base_url('clientes/lista_documentos')?>"><i class="fa fa-circle-o"></i> Estado de Documentos</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
