
<?php
$omar = '';
$cont_graphic = 0;
$rentabilidad = 0;
/**
 * Created by Visual Studio Code.
 * User: Omar
 * Date: 25-01-18
 * Time: 11:37
 */

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha_cartola = new DateTime($fondos['fecha_cartola']['end_date']);
$rango_fecha_aporte = new DateTime($fecha_primer_aporte);
$visor = $this->input->get('visor');
$this->load->model('intranet/Aportesfip');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Reportes AiCapitals > <?php echo $title; ?> > <?php echo $fecha_cartola->format('Y'); ?> > <?php echo strtoupper($meses[$fecha_cartola->format('m')-1]); ?> > (<?php echo ucwords($cliente['nombre']); ?> <?php echo ucwords($cliente['seg_nombre']); ?> <?php echo ucwords($cliente['apellido']); ?> <?php echo ucwords($cliente['seg_apellido']); ?>) </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte'); ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte'); ?>/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte'); ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte'); ?>/dist/css/skins/_all-skins.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte'); ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- CUSTOM AICAPITALS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom_aicapitals.css'); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="shortcut icon" type="image/png" href="https://intranet.aicapitals.cl/static/img/favicon.png"/>
    <?php
    if(!is_null($visor) && $visor == 'on'){
        ?>
        <style>
            #header {
                padding-top: 10px;
                position: fixed;
                top: 0px;
                height: 80px;
                width: 100%;
                z-index: 999;
                background: white;
            }
            #body{ margin-top: 130px; overflow: auto; }
            #header h3
            {
                margin-top : 0px !important;

            }
        </style>
        <?
    }
    ?>
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
        min-width: 360px;
        max-width: 800px;
        margin: 1em auto;
        }

        .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 2px solid #ebebeb;
        margin: 12px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
        }

        .highcharts-data-table caption {
        padding: 2em 0;
        font-size: 1.5em;
        color: #555;
        }

        .highcharts-data-table th {
        font-weight: 600;
        padding: 0.7em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
        padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
        background: #f1f7ff;
        }
    </style>
    <style>
        /* Estilo para el fondo */
        .fondo-cartola{
            background-color: #103851;
        }
        .rounded-cartola{
            border-radius: 15px;
        }
        .text-white{
            color:white;
        }
        .mb-2 {
            margin-bottom: 2rem;
         }
         .p-h3 {
            padding: 0.33rem 1rem;
         }
        .d-inline-block {
            display: inline-block;
        }
        .fondo-cartola-claro{
            background-color: #186FB7;
        }
         
        @media print {
            .container.well{
                opacity: 0;
                height: 1px;
            }
        }

    </style>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


</head>

<body>
    <?php if(!is_null($visor) && $visor == 'on'): ?>
    <div id="header">
        <div class="container well">
            <h3>Seleccione un período</h3>
            <form class="form-inline" action="">
                <input type="hidden" name="visor" value="on"/>
                <div class="form-group">
                    <label for="year">Año:</label>
                    <select class="form-control" id="year" name="year">
                        <?php
                        $now = new DateTime('now');
                        $year = $rango_fecha_aporte->format('Y');

                        for($year = $rango_fecha_aporte->format('Y');$year <= $now->format('Y');$year++){
                            if(!is_null($this->input->get('year')) && $this->input->get('month')){
                                ?>
                                <option value="<?php echo $year; ?>" <?php echo ($this->input->get('year') == $year)?'selected="selected"':""; ?>><?php echo $year; ?></option>
                                <?php
                            }else{
                                ?>
                                <option value="<?php echo $year; ?>" <?php echo ($fecha_cartola->format('Y') == $year)?'selected="selected"':""; ?>><?php echo $year; ?></option>
                                <?php
                            }
                        }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pwd">Mes:</label>
                    <select class="form-control" id="month" name="month">
                        <?php
                        $i = 0;
                        for($i = 1; $i <= count($meses);$i++){
                            if(!is_null($this->input->get('year')) && $this->input->get('month')) {
                                ?>
                                <option value="<?php echo  $i; ?>" <?php echo  ($this->input->get('month') == $i) ? 'selected="selected"' : ""; ?>><?php echo  $meses[$i - 1]; ?></option>
                                <?php
                            }else{
                                ?>
                                <option value="<?php echo  $i; ?>" <?php echo  ($fecha_cartola->format('m') == $i) ? 'selected="selected"' : ""; ?>><?php echo  $meses[$i - 1]; ?></option>
                                <?php
                            }
                        }?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Mostrar</button>
                <?php if(!is_null($this->input->get('year')) && $this->input->get('month')) { ?>
                    <a href="<?php echo current_url(); ?>/?month=<?php echo $this->input->get('month'); ?>&year=<?php echo $this->input->get('year'); ?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Versión para Imprimir</a>
                    <a href="<?=$this->config->item('API_URL')?>exportar/pdfCartola/<?=$cliente['key_encriptada'];?>/<?=$this->input->get('month');?>/<?php echo $this->input->get('year'); ?>" class="btn btn-info" target="_blank"> <i class="fa fa-file"></i> Exportar a PDF</a>
                <?php }else{?>
                <a href="<?php echo current_url(); ?>" class="btn btn-default" target="_blank"> <i class="fa fa-print"></i> Versión para Imprimir</a>
                <a href="<?=$this->config->item('API_URL')?>exportar/pdfCartola/<?=$cliente['key_encriptada'];?>/<?=(int)$now->format('m') - 1;?>/<?=$now->format('Y');?>" class="btn btn-info" target="_blank"> <i class="fa fa-file"></i> Exportar a PDF</a> 
                <!-- <button class="btn btn-info" onclick="imprimir()"> <i class="fa fa-file"></i> Guardar en PDF</button> -->
                <script>
                    function imprimir(){
                       if (window.print) {
                        window.print();
                       }
                    }
                </script>
                <? } ?>
                <button onclick="window.close();" class="btn btn-danger" type="button"><i class="fa fa-remove"></i> Cerrar Cartola</button>
            </form>
        </div>
    </div>
    <? endif; ?>
    <div class="container" id="body">
            <div class="row">
             <p style="font-size: 1rem;
                  color: transparent;
                  ">.</p>
            </div>
        <div class="row fondo-cartola text-white rounded-cartola">

            <div class="col-xs-12">
                <div class="">
                    <img id="logo" class="img-responsive pull-right mb-2" src="<?php echo base_url('assets/img'); ?>/logo-cartola.png" alt="AICapitals">
                </div>
                <div class="invoice-title">

                    <h2>REPORTE MENSUAL</h2>
                    <h3> <strong><?php echo strtoupper($meses[$fecha_cartola->format('m')-1]); ?> | <?php echo $fecha_cartola->format('Y'); ?></strong></h3>
                </div>
                <!-- <div class="clearfix"></div>
                <hr> -->
                <div class="row">


                    <div class="col-xs-6">
                        <address>
                            <strong>Datos del Cliente:</strong><br>
                            <p class="name_client">Nombre Completo: <?php echo ucwords($cliente['nombre']); ?> <?php echo ucwords($cliente['seg_nombre']); ?> <?php echo ucwords($cliente['apellido']); ?> <?php echo ucwords($cliente['seg_apellido']); ?></p>
                            <p>Rut: <?php echo number_format($cliente['rut'],0,',','.'); ?>-<?php echo ucwords($cliente['dv']); ?></p>
                            <p>Dirección: <?php echo ucwords($cliente['direccion']); ?>, <?php echo ucwords($cliente['comuna']); ?>, <?php echo ucwords($cliente['ciudad']); ?></p>
                            <!-- <p class="name_client">Ejecutivo <?php echo ucwords($cliente['rel_ejecutivo_id']); ?> - Cliente <?php echo ucwords($cliente['id']); ?></p>  -->
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Cierre Cartola:</strong><br>
                            <?php echo $fecha_cartola->format('d-m-Y'); ?>
                        </address>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <?php
        if($valores_cuota == 0)
        {
            ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info">
                    <strong>¡Falta información!</strong><br>
                    <p>No se ha podido generar la cartola, porque falta información de los valores cuota del periodo <strong><?php echo $fecha_cartola->format('d-m-Y'); ?></strong></p>
                </div>
            </div>
        </div>

        <?php
        } else {
        ?>
        <div class="row">
            <p style="font-size: 1rem;
                  color: transparent;
                  ">.</p>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="fondo-cartola rounded-cartola text-white p-h3 d-inline-block">A) FONDOS DE INVERSIÓN / SOCIEDADES</h3>

            </div>
        </div>
        <div class="row">
        <?php if (count($fondos) > 2) { ?>
            <?php foreach ($fondos as $fondo) {
                if (isset($fondo['nombre_largo']) && !empty(trim($fondo['nombre_largo']))) {

                    ?>

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading container">
                                    <h3 class="panel-title fondo-cartola-claro rounded-cartola p-h3 text-white d-inline-block"><strong><?php echo strtoupper($fondo['nombre_largo']); ?></strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center"><strong>Fecha</strong></th>
                                                <th class="text-center"><strong>Concepto</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Nº Acciones':'Nº Cuotas';?></strong></th>
                                                <th class="text-center"><strong>Valor <?=($fondo['categoria'] != 'fip')?'Acción':'Cuota';?> a la Fecha</strong></th>
                                                <th class="text-center"><strong>Monto (<?=(($fondo['moneda'] == 'USD')||($fondo['moneda'] == 'EUR'))?$fondo['moneda']:'CLP';?>)</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Saldo de Acciones Nº':'Saldo de Cuotas Nº';?></strong></th>
                                            </tr> 
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (!empty($fondo['movimientos'])) {
                                                ?>
                                                <?php
                                                $suma_acciones = 0;
                                                $capital_devuelto = 0;
                                                $pago_dividendo = 0;
                                                $suma_acciones_clp = 0;
                                                $capital_devuelto_clp = 0;
                                                $pago_dividendo_clp = 0;
                                                
                                                $valor_uf_estimada = $fondo['avance_proyecto'][0]['uf_estimada'];
                                                
                                                     

                                                foreach ($fondo['movimientos'] as $movimiento)
                                                {
                                                       /* echo "<pre>";
                                                         var_dump($movimiento);
                                                       echo "</pre>"; */
                                                        
                                                    

                                                    ?>
                                                    <tr>
                                                        <?php $fecha_movimiento = date_create($movimiento['fecha']); ?>
                                                        <td class="text-center"><?php echo  date_format($fecha_movimiento, 'd-m-Y'); ?></td>  <!-- Fecha -->
                                                        <td class="text-center"><?php echo  $movimiento['concepto']; ?></td> <!-- Concepto --> 
                                                                                                            
                                                        <?php if($movimiento['concepto'] == 'Aporte'||$movimiento['concepto'] == 'Pagaré' )
                                                        {
                                                            $suma_acciones = $suma_acciones + $movimiento['monto_uf'];
                                                            $suma_acciones_clp = $suma_acciones_clp + $movimiento['monto_clp'];
                                                        }
                                                        ?>
                                                        <?php if($movimiento['concepto'] == 'Dev. Capital' || $movimiento['concepto'] == 'Dev. Reajuste Capital')
                                                        {
                                                            if($movimiento['monto_uf'] > 0){
                                                            $capital_devuelto = $capital_devuelto + $movimiento['monto_uf'];}
                                                            else{
                                                            $capital_devuelto = $capital_devuelto - $movimiento['monto_uf'];}
                                                            if($movimiento['monto_clp'] > 0){
                                                                $capital_devuelto_clp = $capital_devuelto_clp + $movimiento['monto_clp'];}
                                                                else{
                                                                    $capital_devuelto_clp = $capital_devuelto_clp - $movimiento['monto_clp'];}
                                                            
                                                        }
                                                        ?>
                                                        <?php if($movimiento['concepto'] == 'Pago Dividendo')
                                                        {
                                                            $pago_dividendo = $pago_dividendo + $movimiento['monto_uf'];
                                                            $pago_dividendo_clp = $pago_dividendo_clp + $movimiento['monto_clp'];
                                                        }
                                                       

                                                        ?>
                                                        <?php
                                                        
                                                        if( !in_array($movimiento['concepto'], array('Pagaré', 'Dev. Capital', 'Pago Dividendo','Dev. Reajuste Capital'))  ){ ?>
                                                            <td class="text-center"><?php echo  str_replace('-','',number_format($movimiento['monto_uf'], 0, ',', '.')); ?></td> <!-- Nº Acciones -->
                                                        <?php }else{ ?>
                                                            <?php if($movimiento['monto_uf'] <> 0) { ?>
                                                            <?if(in_array($movimiento['concepto'], array('Dev. Capital','Dev. Reajuste Capital'))):?>
                                                            <td class="text-center"> -- </td>
                                                            <?else:?>
                                                            <td class="text-center"><?=($movimiento['monto_uf'] < 0)?number_format($movimiento['monto_uf']*-1,2,',','.'):number_format($movimiento['monto_uf'],2,',','.');?></td> <!-- Nº Acciones -->
                                                            <?$omar = $movimiento['monto_uf'];?>
                                                            <?endif;?>
                                                            <?php }else{
                                                                ?>
                                                                <td class="text-center"></td>
                                                                <?php
                                                            } ?>
                                                        <?php } ?>
                                                        <?php if( !in_array($movimiento['concepto'], array('Pagaré', 'Pago Dividendo','Dev. Reajuste Capital','Dev. Capital'))  ){ ?>
                                                        <td class="text-center"><?php echo  str_replace('-','',number_format($movimiento['valor_uf'], '2', ',', '.')); ?></td>
                                                        <?php }else{ ?>
                                                        <td></td>
                                                        <?php } ?>
                                                        <?if($fondo['moneda'] == 'USD'):?>
                                                        <td class="text-center">USD <?php echo  str_replace('-','',number_format($movimiento['monto_uf'], '2', ',', '.')); ?></td>
                                                        <?elseif($fondo['moneda'] == 'EUR'):?>
                                                        <td class="text-center">EUR <?php echo  str_replace('-','',number_format($movimiento['monto_uf'], '2', ',', '.')); ?></td>
                                                        <?else:?>
                                                        <td class="text-center">$ <?php echo  number_format(str_replace('-','',$movimiento['monto_clp']), '0', ',', '.'); ?></td>
                                                        <?endif;?>
                                                        <?php if( !in_array($movimiento['concepto'], array('Pagaré', 'Dev. Capital', 'Pago Dividendo',' Dev. Reajuste Capital', 'Dev. Capital Pagare', 'Dev. Interes Pagare'))  ){ ?>
                                                            <?php if($movimiento['concepto'] == 'Aporte') { ?>
                                                                <td class="text-center"><?php echo  number_format($suma_acciones, '0', ',', '.'); ?></td>
                                                            <?php }else{ ?>
                                                                <?php if ($movimiento['monto_uf'] <> '0') { ?>
                                                                    <?php if( !in_array($movimiento['concepto'], array('Dev. Reajuste Capital'))  ){ ?>
                                                                    <td class="text-center"><?php echo  number_format($movimiento['monto_uf'], '0', ',', '.'); ?></td>
                                                                    <?}else{?>
                                                                    <td></td>
                                                                    <?} ?>
                                                                <?php }else { ?>
                                                                    <td class="text-center"></td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php }else{ ?>
                                                            <?php if ($movimiento['saldo_cuotas'] <> '0') { ?>
                                                                <td class="text-center"><?=$movimiento['saldo_cuotas']?></td>
                                                            <?php }else { ?>
                                                                <td class="text-center"></td>
                                                            <?php } ?>
                                                    <?php } ?>
                                                    </tr>
                                                    <?php


                                                    

                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="alert alert-default"><strong>*No hay movimientos que mostrar</strong></div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered ">
                                            <caption class=""><h5><strong>Resumen del Período</strong></h5></caption>
                                            <thead>
                                            <tr>
                                                <th class="text-center"><strong>Cartola al</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Saldo acciones':'Total cuotas';?></strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Valor contable por acción':'Valor cuota';?></strong></th>
                                                <th class="text-center"><strong>Saldo contable (Ver notas)</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (!empty($fondo['resumenes'])) {
                                                foreach ($fondo['resumenes'] as $resumen) {
                                                    ?>
                                                    <tr>
                                                        <?php $fecha_resumen_periodo = date_create($resumen['periodo']); ?>
                                                        <td class="text-center"><?php echo  date_format($fecha_resumen_periodo, 'd-m-Y'); ?></td>
                                                        <?php
                                                        if ($resumen['concepto'] == 'Aporte') {
                                                            $aportesFipObj = (new Aportesfip())->getById($fondo['aporte_id']);
                                                            if($aportesFipObj->estado_pago == '4'): ?>
                                                                <td class="text-center">0</td>
                                                            <?else:?>
                                                            <td class="text-center"><?php echo  number_format($resumen['cuotas_vigentes'], '0', ',', '.'); ?></td>
                                                            <?endif;?>
                                                            <td class="text-center"><?php echo  number_format($resumen['valor_cuota'], '2', ',', '.'); ?></td>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <?php
                                                        }
                                                        ?>
                                                        <td class="text-center">
                                                        <?php
                                                        $aportesFipObj = (new Aportesfip())->getById($fondo['aporte_id']);
                                                        if($aportesFipObj->estado_pago == '4'): ?>
                                                            0
                                                        <?else:?>
                                                            <?if($fondo['moneda'] == 'USD'):?>
                                                                USD <?php echo  number_format($resumen['saldo_contable'], '0', ',', '.'); ?></td>
                                                            <?elseif($fondo['moneda'] == 'EUR'):?>
                                                                EUR <?php echo  number_format($resumen['saldo_contable'], '0', ',', '.'); ?></td>
                                                            <?else:?>
                                                                $ <?php echo  number_format($resumen['saldo_contable'], '0', ',', '.'); ?></td>
                                                            <?endif;?>
                                                        <?endif;?>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="alert alert-default"><strong>*No hay información que mostrar</strong></div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <? if(count($fondo['avance_proyecto']) > 0) {

                                            $avance_proyecto = $fondo['avance_proyecto'][0];

                                            if ($avance_proyecto['mostrar_grafico_cartola'] == 1) {
                                                ?>
                                                <table class="table table-condensed">
                                                    <tr>
                                                        <td colspan="6"><h3><u>Indicadores del Proyecto</u></h3></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h3>1.- Avance del Proyecto</h3>
                                                        </td>
                                                        <td colspan="1">
                                                            <h3 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h3>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="semaforo vcenter">
                                                                <?
                                                                if ($avance_proyecto['atraso_meses'] <= 3) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/green-dot.png') ?>"
                                                                         width="18" height="18" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="18" height="18" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                                <?php
                                                                if ($avance_proyecto['atraso_meses'] > 3 && $avance_proyecto['mostrar_rojo'] == 0) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/yellow-dot.png') ?>"
                                                                         width="18" height="18" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="18" height="18" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                                <?php
                                                                if ($avance_proyecto['atraso_meses'] > 3 && $avance_proyecto['mostrar_rojo'] == 1) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/red-dot.png') ?>"
                                                                         width="18" height="18" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="18" height="18" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                            </div>
                                                        </td>
                                                        <td colspan="1">
                                                            <table class="">
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/green-dot.png') ?>"
                                                                             width="18" height="18"/></td>
                                                                    <td>Proyecto avanzando de acuerdo a lo estimado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/yellow-dot.png') ?>"
                                                                             width="18" height="18"/></td>
                                                                    <td>Proyecto avanzando más lento a lo estimado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/red-dot.png') ?>"
                                                                             width="18" height="18"/></td>
                                                                    <td>Proyecto con problemas en su desarrollo</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h3>2.- Progreso Estimado</h3>
                                                        </td>
                                                        <td colspan="1">
                                                            <h3 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h3>
                                                        </td>
                                                        <td colspan="3" style="vertical-align: middle">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="progressbar">
                                                                        <div align="center"
                                                                             style="width: <?= $avance_proyecto['avance_porcentaje'] ?>% !important; min-width: 90px;">
                                                                            <p style="color:white !important;"><?= $avance_proyecto['avance_meses']; ?> de <?= $avance_proyecto['duracion_real_proyectada_cierre']; ?> Meses</p></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                        <?  } ?>
                                            <?
                                            $this->load->model('intranet/fip');
                                            $this->load->model('intranet/Aportesfip');
                                            $fip = (new Fip())->getById($avance_proyecto['rel_fip_id']);
                                            $aportesFip = (new Aportesfip())->getById($fondo['aporte_id']);
                                            $grupo = $aportesFip->getGrupofondoaporte();
                                            if($fip->is_multi_calls){
                                                $call = $aportesFip->getCall();
                                                $series = $call->getSeries();
                                            }else{
                                                $series = $fip->getSeries();
                                            }
                                            ?>
                                                    <?if($avance_proyecto['mostrar_roe']== 1):?>

                                                    <?php
                                                        if(count($series) > 0){
                                                    ?>
                                                    <? if ($avance_proyecto['mostrar_grafico_cartola'] == 0) { ?>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <td colspan="6"><h3><u>Indicadores del Proyecto</u></h3></td>
                                                        </tr>
                                                    <? } ?>

                                                    <tr>
                                                        <td colspan="2">
                                                        <?
                                                        $indicador_retorno = 1;
                                                        $this->load->model('intranet/Fipindicador');
                                                        if(isset($avance_proyecto['rel_indicador_fip_id'])){
                                                            $indicador_retorno = $avance_proyecto['rel_indicador_fip_id'];
                                                        }else{
                                                            $indicador_retorno = $fip->getIndicador();
                                                            $indicador_retorno = $indicador_retorno->id;
                                                            }

                                                        if ($avance_proyecto['mostrar_grafico_cartola'] == 1) {
                                                            if($indicador_retorno == Fipindicador::INDICADOR_ROE || $avance_proyecto['rel_indicador_fip_id'] == Fipindicador::INDICADOR_ROE):
                                                            ?>
                                                            <h3>3.- Retorno Estimado</h3>
                                                                <?
                                                            elseif($indicador_retorno == Fipindicador::INDICADOR_TIR || $avance_proyecto['rel_indicador_fip_id'] == Fipindicador::INDICADOR_TIR):
                                                                ?>
                                                            <h3>3.- Tasa Interna de Retorno Estimada</h3>
                                                                <?
                                                            endif;
                                                            }else{
                                                                if($indicador_retorno == Fipindicador::INDICADOR_ROE || $avance_proyecto['rel_indicador_fip_id'] == Fipindicador::INDICADOR_ROE):
                                                            ?>
                                                            <h3>1.- Retorno Estimado</h3>
                                                            <?
                                                                elseif($indicador_retorno == Fipindicador::INDICADOR_TIR || $avance_proyecto['rel_indicador_fip_id'] == Fipindicador::INDICADOR_TIR):
                                                                ?>
                                                            <h3>1.- Tasa Interna de Retorno Estimada</h3>
                                                                <?
                                                                endif;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td colspan="1">
                                                            <h3 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h3>
                                                        </td>
                                                        <td colspan="3" style="vertical-align: middle">
                                                            <?if(!empty($grupo)){

                                                                if($fip->is_multi_calls == false){
                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                        echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                    }else {
                                                                        echo '<h3 >' . $grupo->getGrupofondo()->getSerie() . ' '."  ".$fip->getMoneda()->moneda.' + ' . number_format($grupo->getGrupofondo()->getRoe(),1,',','.') . '%</h3>';
                                                                    }
                                                                }else{
                                                                    $monto_uf_aporte = $grupo->getGrupofondo()->getSumaAportes();
                                                                    $masdeUnAporte = $aportesFip->tieneMasDeUnAporte();

                                                                    if(count($masdeUnAporte) > 0):

                                                                    ?>
                                                                    <table width="100%">
                                                                    <thead>
                                                                        <tr style="text-align:center;">
                                                                            <th>Fecha</th>
                                                                            <th>Monto</th>
                                                                            <th>Call</th>
                                                                            <th>Retorno Estimado</th>
                                                                        </tr>
                                                                    </thead>
                                                                        <?
                                                                        $this->load->model('intranet/Fipinfoextra');
                                                                        foreach($masdeUnAporte as $auxAporte):
                                                                           $auxCall = $auxAporte->getCall();

                                                                            $series = $auxCall->getSeries();

                                                                            $fipInfoExtra = new Fipinfoextra();
                                                                            $aux_avance_proyecto = $fipInfoExtra->getLastInfoExtraForFip($auxAporte->rel_aporte_fip_id, $auxCall->nombre, true);



                                                                            ?>
                                                                            <tr style="border-bottom: 1px solid black;">
                                                                                <td><?=(new DateTime($auxAporte->fecha))->format('d-m-Y');?></td>
                                                                                <td><?=number_format($auxAporte->aportado_uf,0,',','.');?> <?=$auxAporte->getFip()->getMoneda()->moneda;?></td>
                                                                                <td>Call <?=$auxAporte->getCall()->nombre;?></td>
                                                                                <td>
                                                                                <?

                                                                                if ($monto_uf_aporte >= $series[0]->minimo && $monto_uf_aporte <= $series[0]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_a'])) ? $series[0]->rentabilidad : $aux_avance_proyecto['roe_serie_a'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_a'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[0]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';

                                                                                    }

                                                                                } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $aux_avance_proyecto['roe_serie_b'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_b'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[1]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $aux_avance_proyecto['roe_serie_c'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_c'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[2]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                } else {
                                                                                    if(isset($series[3])) {
                                                                                        /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $aux_avance_proyecto['roe_serie_d'];*/
                                                                                        $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                            echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                        }else {
                                                                                               echo '' . $series[3]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                              }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                        <!-- <div class="col-xs-12">
                                                            <figure class="highcharts-figure">
                                                                <div id="container<?= $cont_graphic; ?>"></div>
                                                                <p class="highcharts-description"> Estudio de Rentabildad Total de la Adminstradora de Fondos AIC </p>
                                                            </figure>
                                                         </div>
                                                         <div class="col-xs-12">
                                                           <figure class="highcharts-figure">
                                                                <p class="highcharts-description"> Valores asociados a su Inversión </p>
                                                                <p>Inversión Inicial <?= $monto_uf_aporte; ?> UF </p>
                                                                <p>Retorno Total Esperado <?= $monto_uf_aporte + $monto_uf_aporte*($rentabilidad/100);?> UF </p>
                                                                <p>ROE <?=$rentabilidad;?> %</p>
                                                                <p>Dividendos Esperados sobre Inversion <?= $monto_uf_aporte*($rentabilidad/100);?> UF </p>
                                                           </figure>
                                                         </div>
                                                    </tr> -->



                                                    <script>
                                                        Highcharts.chart('container<?= $cont_graphic; ?>', {

                                                        title: {
                                                        text: 'Análisis de Rentabilidad de Fondos Administradora AIC',
                                                        align: 'left'
                                                        },

                                                        subtitle: {
                                                        text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>',
                                                        align: 'left'
                                                        },

                                                        yAxis: {
                                                        title: {
                                                            text: '%'
                                                        }
                                                        },

                                                        xAxis: {
                                                        accessibility: {
                                                            rangeDescription: 'Range: 2020 to 202'
                                                        }
                                                        },

                                                        legend: {
                                                        layout: 'vertical',
                                                        align: 'right',
                                                        verticalAlign: 'middle'
                                                        },

                                                        plotOptions: {
                                                        series: {
                                                            label: {
                                                            connectorAllowed: false
                                                            },
                                                            pointStart: 0
                                                        }
                                                        },

                                                        series: [{
                                                        name: 'Rentabilidad Esperada al Final',
                                                        data: [0, <?= $rentabilidad;?>],
                                                        }],

                                                        responsive: {
                                                        rules: [{
                                                            condition: {
                                                            maxWidth: 500
                                                            },
                                                            chartOptions: {
                                                            legend: {
                                                                layout: 'horizontal',
                                                                align: 'center',
                                                                verticalAlign: 'bottom'
                                                            }
                                                            }
                                                        }]
                                                        }

                                                        });

                                                    </script>
                                                    <?php $cont_graphic++; ?>
                                                                            <?
                                                                        endforeach;
                                                                        ?>
                                                                    </table>
                                                                    <?
                                                                    else:
                                                                        $call = $aportesFip->getCall();
                                                                        $series = $call->getSeries();

                                                                    if ($monto_uf_aporte >= $series[0]->minimo && $monto_uf_aporte <= $series[0]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_a'])) ? $series[0]->rentabilidad : $avance_proyecto['roe_serie_a'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[0]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                    } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                    } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                    } else {
                                                                        if(isset($series[3])) {
                                                                            /*$rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];*/
                                                                            $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';

                                                                            }
                                                                        }
                                                                    }
                                                                    endif;
                                                                }
                                                            }else {
                                                                $masdeUnAporte = $aportesFip->tieneMasDeUnAporte();
                                                                if($fip->is_multi_calls == true){
                                                                    if(count($masdeUnAporte) > 1){
                                                                    ?>
                                                                    <table width="100%">
                                                                    <thead>
                                                                        <tr style="text-align:center;">
                                                                            <th>Fecha</th>
                                                                            <th>Monto</th>
                                                                            <th>Call</th>
                                                                            <th>Retorno Estimado</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <?
                                                                    $this->load->model('intranet/Fipinfoextra');
                                                                        foreach($masdeUnAporte as $auxAporte):
                                                                            $auxCall = $auxAporte->getCall();
                                                                            $series = $auxCall->getSeries();
                                                                            $fipInfoExtra = new Fipinfoextra();
                                                                            $aux_avance_proyecto = $fipInfoExtra->getLastInfoExtraForFip($auxAporte->rel_aporte_fip_id, $auxCall->nombre, true);

                                                                            ?>
                                                                            <tr style="border-bottom: 1px solid black;">
                                                                                <td><?=(new DateTime($auxAporte->fecha))->format('d-m-Y');?></td>
                                                                                <td><?=number_format($auxAporte->aportado_uf,0,',','.');?> <?=$auxAporte->getFip()->getMoneda()->moneda;?></td>
                                                                                <td>Call <?=$auxAporte->getCall()->nombre;?></td>
                                                                                <td>
                                                                                <?
                                                                                if ($monto_uf_aporte >= $series[0]->minimo && $monto_uf_aporte <= $series[0]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_a'])) ? $series[0]->rentabilidad : $aux_avance_proyecto['roe_serie_a'];
                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_a'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[0]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $aux_avance_proyecto['roe_serie_b'];


                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_b'];
                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[1]->serie . ' &nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $aux_avance_proyecto['roe_serie_c'];
                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_c'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[2]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                } else {
                                                                                    if(isset($series[3])) {
                                                                                        $rentabilidad = (empty($aux_avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $aux_avance_proyecto['roe_serie_d'];
                                                                                        $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                            echo '' . $series[0]->serie . '&nbsp;&nbsp;  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                        }else {
                                                                                            echo '' . $series[3]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                              }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                </td>
                                                    <!-- <tr>
                                                         <div class="col-xs-12">
                                                            <figure class="highcharts-figure">
                                                                <div id="container<?= $cont_graphic; ?>"></div>
                                                                <p class="highcharts-description"> Estudio de Rentabildad Total de la Adminstradora de Fondos AIC </p>
                                                            </figure>
                                                         </div>
                                                         <div class="col-xs-12">
                                                           <figure class="highcharts-figure">
                                                                <p class="highcharts-description"> Valores asociados a su Inversión </p>
                                                                <p>Inversión Inicial <?= $monto_uf_aporte; ?> UF </p>
                                                                <p>Retorno Total Esperado <?= $monto_uf_aporte + $monto_uf_aporte*($rentabilidad/100);?> UF </p>
                                                                <p>ROE <?=$rentabilidad;?> %</p>
                                                                <p>Dividendos Esperados sobre Inversion <?= $monto_uf_aporte*($rentabilidad/100);?> UF </p>
                                                           </figure>
                                                         </div>
                                                    </tr> -->



                                                    <script>
                                                        Highcharts.chart('container<?= $cont_graphic; ?>', {

                                                        title: {
                                                        text: 'Análisis de Rentabilidad de Fondos Administradora AIC',
                                                        align: 'left'
                                                        },

                                                        subtitle: {
                                                        text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>',
                                                        align: 'left'
                                                        },

                                                        yAxis: {
                                                        title: {
                                                            text: '%'
                                                        }
                                                        },

                                                        xAxis: {
                                                        accessibility: {
                                                            rangeDescription: 'Range: 2020 to 202'
                                                        }
                                                        },

                                                        legend: {
                                                        layout: 'vertical',
                                                        align: 'right',
                                                        verticalAlign: 'middle'
                                                        },

                                                        plotOptions: {
                                                        series: {
                                                            label: {
                                                            connectorAllowed: false
                                                            },
                                                            pointStart: 0
                                                        }
                                                        },

                                                        series: [{
                                                        name: 'Rentabilidad Esperada al Final',
                                                        data: [0, <?= $rentabilidad;?>],
                                                        }],

                                                        responsive: {
                                                        rules: [{
                                                            condition: {
                                                            maxWidth: 500
                                                            },
                                                            chartOptions: {
                                                            legend: {
                                                                layout: 'horizontal',
                                                                align: 'center',
                                                                verticalAlign: 'bottom'
                                                            }
                                                            }
                                                        }]
                                                        }

                                                        });

                                                    </script>
                                                    <?php $cont_graphic++; ?>

                                                                            <?
                                                                        endforeach;
                                                                    ?>
                                                                    </table>
                                                                    <?
                                                                    }else{
                                                                        $call = $aportesFip->getCall();
                                                                        $series = $call->getSeries();
                                                                        $monto_uf_aporte = $fondo['movimientos'][0]['monto_uf'];
                                                                        if ($monto_uf_aporte >= $series[0]->minimo && $monto_uf_aporte <= $series[0]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_a'])) ? $series[0]->rentabilidad : $avance_proyecto['roe_serie_a'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[0]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                        } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                        } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                        } else {
                                                                            if(isset($series[3])) {
                                                                                $rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];


                                                                                if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                    echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                                }else {
                                                                                    echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';

                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }else{
                                                                    $monto_uf_aporte = $fondo['movimientos'][0]['monto_uf'];
                                                                    if ($monto_uf_aporte >= $series[0]->minimo && $monto_uf_aporte <= $series[0]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_a'])) ? $series[0]->rentabilidad : $avance_proyecto['roe_serie_a'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[0]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                    } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                    } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                    } else {
                                                                        if(isset($series[3])) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                                  }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </td>
                                                    </tr> <!-- Prueba Datos -->
                                                   


                                                    <script>
                                                        Highcharts.chart('container<?= $cont_graphic; ?>', {

                                                        title: {
                                                        text: 'RETORNO ESPERADO',
                                                        align: 'left'
                                                        },

                                                        subtitle: {
                                                        text: '%',
                                                        align: 'left'
                                                        },

                                                        yAxis: {
                                                        title: {
                                                            text: '%'
                                                        }
                                                        },

                                                        xAxis: {
                                                        accessibility: {
                                                            rangeDescription: 'Range: 2015 to 2026'
                                                        }
                                                        },

                                                        legend: {
                                                        layout: 'vertical',
                                                        align: 'right',
                                                        verticalAlign: 'middle'
                                                        },

                                                        plotOptions: {
                                                        series: {
                                                            label: {
                                                            connectorAllowed: false
                                                            },
                                                            pointStart: 0
                                                        }
                                                        },

                                                        series: [{
                                                        name: 'ROE <?= $most_rent;?>%',
                                                        data: [0, <?= $most_rent;?>],
                                                        }],

                                                        responsive: {
                                                        rules: [{
                                                            condition: {
                                                            maxWidth: 500
                                                            },
                                                            chartOptions: {
                                                            legend: {
                                                                layout: 'horizontal',
                                                                align: 'center',
                                                                verticalAlign: 'bottom'
                                                            }
                                                            }
                                                        }]
                                                        }

                                                        });

                                                    </script>
                                          
                                                    <?php $cont_graphic++;
                                                      $rentabilidad =0;
                                                      $most_rent =0; ?>
                                                    <?
                                                        }
                                                    ?>
                                                    <?endif;?>
                                                </table>
                                        <? }?>
                                    </div>
                                    </hr>
                                    <div class="alert alert-grey container">
                                        <strong>Nota:</strong>
                                        <ol>
                                            <li><p>Estimado Inversionista, para su información y mejor comprensión de la cartola, queremos indicarle que el valor cuota o acción a la fecha de esta cartola es referencial, y está basado en el valor contable del patrimonio del Fondo o Sociedad, donde la inversión en el proyecto está reflejada a su valor histórico y no en base al Valor Económico del Proyecto.</p></li>
                                            <?if(isset($series) && count($series) > 0 && $avance_proyecto['mostrar_roe']== 1):?>
                                            <li><p>El indicador de Retorno Estimado es una proyección efectuada con la información proporcionada por la Inmobiliaria Gestora del proyecto y algunos supuestos propios.</p></li>
                                            <? endif; ?>
                                            <?if(isset($fondo['comentario'])):?>
                                            <li><p><?=$fondo['comentario'];?></p></li>
                                            <?endif;?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php
                }
            }
        }else{
            ?>
            <div class="col-xs-12">
                <div class="well">
                    <strong>No se registran fondos.</strong>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <!-- FIN RESUMEN DE FONDOS AIC -->
        <!-- FONDOS MUTUOS -->
        <!-- <div class="row">
            <div class="col-xs-12">
                <h3 class ="panel-title fondo-cartola-claro rounded-cartola p-h3 text-white d-inline-block">B) FONDOS MUTUOS Y OTRAS INVERSIONES</h3>
            </div>
            <div class="col-xs-12">
                <div class="well">
                    <strong>Sin inversiones</strong>
                </div>
            </div>
        </div>
        <!-- FIN FONDOS MUTUOS -->
        <!-- RESUMEN -->
        <div class="">
            <div class="col-xs-12">
                <h3 class="fondo-cartola rounded-cartola text-white p-h3 d-inline-block">C) RESUMEN</h3>
            </div>
            <div class="col-xs-12">
                <h4 class="fondo-cartola rounded-cartola text-white p-h3 d-inline-block">1. FONDOS DE INVERSIÓN / SOCIEDADES</h4>
            </div>
            <?php if (count($fondos) > 2) { ?>
            <div class="col-xs-12">
                <div class="">
                    <?foreach($resumenes_saldos as $k => $resumenes_saldo):?>
                        <? if($k == 'USD'): ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                                 <h4 class ="fondo-cartola rounded-cartola text-white p-h3 d-inline-block">FONDOS EN DÓLARES</h4>

<table class="table table-bordered fondo-cartola-claro rounded-cartola p-h3 text-white panel-title">

    <thead>
        <tr>
            <th class="col-md-6"></th>
            <th class="col-md-2 text-center">Patrimonio</th>
            <th class="col-md-2 text-center">% de la cartera</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $sumaPorcentajePatrimonio = 0;
        $sumaPatrimonio = 0;

        foreach($resumenes_saldo as $resumen){
            $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
        }

        /*echo "<pre>";
        var_dump($movimientos);
        var_dump($clientes);
        var_dump($fondos);
        var_dump($resumenes);
        var_dump($resumenes_saldos);
        echo "</pre>";*/

        if(!empty($resumenes_saldos)){

            foreach ($resumenes_saldo as $resumen) {
                 ?>
                <tr>
                <td><?= strtoupper($resumen['nombre_largo']) ?></td>
                <td class="text-center">USD <?= number_format($resumen['saldo_contable'], 0,',','.') ?></td>
                <?php
                if($resumen['saldo_contable'] > 0 && $sumaPatrimonio > 0 ){
                    $sumaPorcentajePatrimonio = $sumaPorcentajePatrimonio + (($resumen['saldo_contable']/$sumaPatrimonio)*100);
                    ?>
                    <td class="text-center"> <?= number_format((($resumen['saldo_contable']/$sumaPatrimonio)*100),1,',','.') ?> %</td>
                    <?php
                }else{ ?>
                    <td class="text-center">0</td>
                    <?php
                    $sumaPorcentajePatrimonio = $sumaPorcentajePatrimonio + 0;
                }
                ?>
            </tr>
            <?php }
        } ?>
    </tbody>

    <tfoot>
        <tr style="border-top-color: #0a0a0a !important;">
            <td class="text-right">
                <strong>Total</strong>
            </td>
            <td class="text-center">
                <strong>USD <?= number_format($sumaPatrimonio,0, ',','.' ) ?></strong>
            </td>
            <td class="text-center">
                <strong><?= number_format($sumaPorcentajePatrimonio,0,',','.') ?> %</strong>
            </td>
        </tr>
    </tfoot>

</table>

</div>
</div>
<? elseif($k == 'EUR'): ?>
    <div class="row">
                            <div class="col-xs-12">
                                <hr>
                                 <h4 class ="fondo-cartola rounded-cartola text-white p-h3 d-inline-block">FONDOS EN EUROS</h4>

<table class="table table-bordered fondo-cartola-claro rounded-cartola p-h3 text-white panel-title">

    <thead>
        <tr>
            <th class="col-md-6"></th>
            <th class="col-md-2 text-center">Patrimonio</th>
            <th class="col-md-2 text-center">% de la cartera</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $sumaPorcentajePatrimonio = 0;
        $sumaPatrimonio = 0;

        foreach($resumenes_saldo as $resumen){
            $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
        }

        if(!empty($resumenes_saldos)){

            foreach ($resumenes_saldo as $resumen) {
                 ?>
                <tr>
                <td><?= strtoupper($resumen['nombre_largo']) ?></td>
                <td class="text-center">EUR <?= number_format($resumen['saldo_contable'], 0,',','.') ?></td>
                <?php
                if($resumen['saldo_contable'] > 0 && $sumaPatrimonio > 0 ){
                    $sumaPorcentajePatrimonio = $sumaPorcentajePatrimonio + (($resumen['saldo_contable']/$sumaPatrimonio)*100);
                    ?>
                    <td class="text-center"> <?= number_format((($resumen['saldo_contable']/$sumaPatrimonio)*100),1,',','.') ?> %</td>
                    <?php
                }else{ ?>
                    <td class="text-center">0</td>
                    <?php
                    $sumaPorcentajePatrimonio = $sumaPorcentajePatrimonio + 0;
                }
                ?>
            </tr>
            <?php }
        } ?>
    </tbody>

    <tfoot>
        <tr style="border-top-color: #0a0a0a !important;">
            <td class="text-right">
                <strong>Total</strong>
            </td>
            <td class="text-center">
                <strong>EUR <?= number_format($sumaPatrimonio,0, ',','.' ) ?></strong>
            </td>
            <td class="text-center">
                <strong><?= number_format($sumaPorcentajePatrimonio,0,',','.') ?> %</strong>
            </td>
        </tr>
    </tfoot>

</table>

</div>
</div>
<? else: ?>

<div class="row">
<div class="col-xs-12">

                                <h4 class ="fondo-cartola rounded-cartola text-white p-h3 d-inline-block">FONDOS EN PESOS</h4>
                                <table class="table table-bordered fondo-cartola-claro rounded-cartola p-h3 text-white panel-title">
                                    <thead>
                                    <tr>
                                        <th class="col-md-6"></th>
                                        <th class="col-md-2 text-center">Patrimonio</th>
                                        <th class="col-md-2 text-center">% de la cartera</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sumaPorcentajePatrimonio = 0;
                                    $sumaPatrimonio = 0;
                                    if(!empty($resumenes_saldos))
                                    {

                                        $cantidadResumenesSaldos = count($resumenes_saldo);
                                        foreach($resumenes_saldo as $resumen){
                                            $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
                                        }

                                        foreach ($resumenes_saldo as $resumen)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo strtoupper($resumen['nombre_largo']); ?></td>
                                                <td class="text-center">$ <?php echo number_format($resumen['saldo_contable'], 0,',','.'); ?></td>
                                                <?php
                                                if($resumen['saldo_contable'] > 0 && $sumaPatrimonio > 0 ){
                                                    $sumaPorcentajePatrimonio = $sumaPorcentajePatrimonio + (($resumen['saldo_contable']/$sumaPatrimonio)*100);
                                                    ?>
                                                    <td class="text-center"> <?php echo number_format((($resumen['saldo_contable']/$sumaPatrimonio)*100),1,',','.'); ?> %</td>
                                                    <?php
                                                }else{ ?>
                                                    <td class="text-center">0</td>
                                                    <?php
                                                    $sumaPorcentajePatrimonio = $sumaPorcentajePatrimonio + 0;
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr style="border-top-color: #0a0a0a !important;">
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td class="text-center"><strong>$ <?php echo number_format($sumaPatrimonio,0, ',','.' ); ?></strong></td>
                                        <td class="text-center"><strong><?php echo number_format($sumaPorcentajePatrimonio,0,',','.'); ?> %</strong></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <? endif; ?>

                    <? endforeach;?>
                </div>
            </div>
            <?php } else {
                ?>
                <div class="col-xs-12">
                    <div class="well">
                        <strong>No hay información para mostrar.</strong>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- FIN RESUMEN -->
    </div>
    <?php
    }
    ?>


</body>

</html>
