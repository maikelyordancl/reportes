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
            <small>Listado Global</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('/dashboard')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li >Listado Global</li>
            <li class="active">Listar</li>
        </ol>
    </section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" name="filtro" action="<?=base_url('clientes/lista_global/')?>" method="get" autocomplete="off">
                <fieldset class="well the-fieldset">
                    <legend class="the-legend">Filtros del Reporte</legend>
                    <div class="form-group">
                        <label for="estado_cliente">Estado Cliente</label>
                        <select class="form-control" id="estado_cliente" name="estado_cliente">
                            <option value="">Todos</option>
                            <?php
                            foreach ($estadosCliente as $estado) {
                                ?>
                                <option <?=(!is_null($this->input->get('estado_cliente')) && $this->input->get('estado_cliente') == $estado['id']?' selected ':'');?> value="<?=$estado['id'];?>"><?=ucwords($estado['estado_cliente']);?></option>
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
                        <!--<label><b>¿Acepta Mailing?</b> <input type="checkbox" class="form-control" name="mailing" /> </label>-->
                        <label><b>¿Acepta Mailing?</b> <input type="checkbox" class="" name="mailing" <?=($this->input->get('mailing') == 'on')?' checked ':''?> /> </label>
                    </div>
                    <div class="form-group">
                        <label><b>Sólo liquidados</b> <input type="checkbox" class="" name="liquidados" <?=($this->input->get('liquidados') == 'on')?' checked ':''?> /> </label>
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
                    <h3 class="box-title">Listado de Clientes</h3>
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
                                    'Rut',
                                    'Nombre',
                                    'Seg Nombre',
                                    'Apellido',
                                    'Seg Apellido',
                                    'Dirección',
                                    'Comuna',
                                    'Ciudad',
                                    'Fecha Ingreso',
                                    'Celular',
                                    'Oficina',
                                    'Fecha Nacimiento',
                                    'Mail',
                                    'Estado Cliente',
                                    'Ejecutivo',
                                    'Mail Ejecutivo',
                                    'Representante Rut',
                                    'Representatne Nombre',
                                    'Representante Mail'));

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