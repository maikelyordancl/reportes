<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 28-11-17
 * Time: 04:25
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Clientes
            <small>Listado de Estado de Documentos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('/dashboard')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li >Listado de Estado de Documentos</li>
            <li class="active">Listar</li>
        </ol>
    </section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" name="filtro" action="<?=base_url('clientes/lista_documentos/')?>" method="get" autocomplete="off">
                <fieldset class="well the-fieldset">
                    <legend class="the-legend">Filtros del Reporte</legend>
                    <div class="form-group">
                        <label for="estado_cliente">Estado Aporte</label>
                        <select class="form-control" id="estado_pago" name="estado_pago">
                            <option value="ALL">Todos</option>
                            <?php
                            foreach ($estadoPagos as $estadoPago) {
                                ?>
                                <option <?=(!is_null($this->input->get('estado_pago')) && $this->input->get('estado_pago') == $estadoPago['id']?' selected ':'');?> value="<?=$estadoPago['id'];?>"><?=ucwords($estadoPago['nombre']);?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ejecutivo">Ejecutivo Asociado</label>
                        <select class="form-control" id="ejecutivo" name="ejecutivo">
                            <option value="">Todos</option>
                            <?php
                            if(count($ejecutivos) > 0) {
                                foreach ($ejecutivos as $ejecutivo) {
                                    ?>
                                    <option <?=(!is_null($this->input->get('ejecutivo')) && $this->input->get('ejecutivo') == $ejecutivo['id']?' selected ':'');?> value="<?= $ejecutivo['id']; ?>"><?= ucwords($ejecutivo['first_name'] . ' ' . $ejecutivo['last_name']); ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ejecutivo">Fondo de Inversion</label>
                        <select class="form-control" id="fondo_inversion" name="fondo_inversion">
                            <option value="">Todos</option>
                            <?php
                            if(count($fondosInversion) > 0) {
                                foreach ($fondosInversion as $fondo_inversion) {
                                    ?>
                                    <option <?=(!is_null($this->input->get('fondo_inversion')) && $this->input->get('fondo_inversion') == $fondo_inversion['id']?' selected ':'');?> value="<?= $fondo_inversion['id']; ?>"><?= ucwords($fondo_inversion['nombre_fondo']); ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                    </div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                </fieldset>


            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Listado de Clientes Documentos</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="reporte">
                        <?php
                        $template = array(
                            'table_open'            => '<table class="tbl-reporte display compact" id="tbl-reporte" >');

                        if($this->input->get())
                        {
                            if($clientes) {
                                $this->table->set_template($template);
                                $this->table->set_heading(array(
                                    '#',
                                    'Rut',
                                    'Nombre Cliente',
                                    'Correo Cliente',
                                    'Cédula Cliente',
                                    'Ficha Cliente',
                                    'Fecha Ingreso Cliente',
                                    'Ejecutivo',
                                    'Correo Ejecutivo'
                                    ));

                                echo $this->table->generate($clientes);
                            }else{
                            ?>
                                <div class="alert alert-info"><strong>¡Información!</strong> La consulta no obtuvo resultados.</div>
                            <?php
                            }
                        }else{
                            ?>
                            <div class="alert alert-info"><strong>¡Información!</strong> Utilice el filtro para mostrar los resultados.</div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

</div>