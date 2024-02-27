
<?php
$omar = '';
$cont_graphic = 0;
$resumen_dev;
$resumen_ii;
$resumen_por_recibir;
$resumen_devuleto;
/**
 * Created by Visual Studio Code.x
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('fondo.php'); // Incluye el archivo PHP para generar el CSS dinámicamente ?>
    


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
        font-size: 1.5em;
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

        .letra{
            font-size: 1.5em;
        }

        .highcharts-data-table caption {
        padding: 2em 0;
        font-size: 2em;
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
            background-color: #D0CECE;
        }
        .rounded-cartola{
            border-radius: 7px;
        }
        .text-white{
            color:white;
        }

        .text-blue-aic{
            color:#0F2A3D;
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
            background-color: #D0CECE;
        }

        .thead-dark{
            background-color: #166EB6;
                       
        }

        .tr-fondo-capital{
            background-color: #D8D8D8;
                       
        }

        .tr-fondo-dividendos{
            background-color: #1d335c;
                       
        }

        .encabezados{
            background-color: #7462FA;            
        }

        .fondo-encabezado{
            background-color: white;
        }

        .px-3{
            padding-left: 3rem;
            padding-right: 3rem;            
        } 

        .por{
           font-size: 30px; /* Puedes ajustar el valor a tu preferencia */
        }

        .repor{
           font-size: 40px; /* Puedes ajustar el valor a tu preferencia */
        }



        .bod {
            display: flex;
            justify-content: center;
            align-items: center;
            
            
        }

        .cent{
            margin-bottom: center-block;
        }

        .page-break-up {
            page-break-before: always;
        }

        .page-break-down {
            page-break-after: always;
        }

        .page-break {
        page-break-before: always;
        }
              
          
        
        @media print {
            .container.well{
                opacity: 0;
                height: 1px;
                
            }
        }

    </style>

    <!-- <style>
        body {
            background-color: #103851;
            background-repeat: no-repeat;
            background-size: cover; /* Ajusta la imagen al tamaño del body */
            background-position: center; /* Posiciona la imagen en el centro del body */
        }
    </style>  -->

       
    <style>
         
        body {
            background: repeating-linear-gradient(90deg, #103851, #2a4e64 50%, #7a919f 75%, #FFFFFF 100%);
        }
        strong {
            text-transform: uppercase;
        }
    </style>

   

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>



</head>

<body>
            
    <?php if(!is_null($visor) && $visor == 'on'): ?>
    <div id="header">
        <div class="well container">
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
                    <!-- <button class="btn btn-info" onclick="imprimir()"> <i class="fa fa-file"></i> Guardar en PDF</button>
                    <script>
                    function imprimir(){
                       if (window.print) {
                        window.print();
                       }
                    }
                </script> -->
                <?php }else{?>
                <a href="<?php echo current_url(); ?>" class="btn btn-default" target="_blank"> <i class="fa fa-print"></i> Versión para Imprimir</a>
                <a href="<?=$this->config->item('API_URL')?>exportar/pdfCartola/<?=$cliente['key_encriptada'];?>/<?=(int)$now->format('m') - 1;?>/<?=$now->format('Y');?>" class="btn btn-info" target="_blank"> <i class="fa fa-file"></i> Exportar a PDF</a> 
                <!-- <button class="btn btn-info" onclick="imprimir()"> <i class="fa fa-file"></i> Guardar en PDF</button> 
                <script>
                    function imprimir(){
                       if (window.print) {
                        window.print();
                       }
                    }
                </script> -->
                <? } ?>
                <button onclick="window.close();" class="btn btn-danger" type="button"><i class="fa fa-remove"></i> Cerrar Cartola</button>
            </form>
        </div>
    </div>
    <? endif; ?>
    <div class="container" id="body">
    
            <div class="row">
             <p style="font-size: 0.5rem;
                  color: transparent;
                  ">.</p>
            </div>
        <div class="row text-blue-aic fondo-encabezado rounded-cartola px-3">

                             

            <div class="col-xs-12">
                 <div>
                   <center> <img id="logo" class="img-responsive pull-center mb-2 cent" src="<?php echo base_url('assets/img'); ?>/logotipo.png" alt="AICapitals"> </center>
                </div>

                
                
                <!-- <div class="clearfix"></div>
                 -->
                


                    <div class="col-xs-12 text-center por text-blue-aic">
                        <address>

                            <div class="invoice-title text-center">
                                <strong class="repor">CARTOLA MENSUAL</strong><br>
                                <h3 class="repor"> <strong><?php echo strtoupper($meses[$fecha_cartola->format('m')-1]); ?> | <?php echo $fecha_cartola->format('Y'); ?></strong></h3><br><br>
                            </div>
                            
                            <strong class="por">Datos del Cliente:</strong><br>
                            <p class="por"><?php echo ucwords($cliente['nombre']); ?> <?php echo ucwords($cliente['seg_nombre']); ?> <?php echo ucwords($cliente['apellido']); ?> <?php echo ucwords($cliente['seg_apellido']); ?></p>
                            <p class="por"><?php echo number_format($cliente['rut'],0,',','.'); ?>-<?php echo ucwords($cliente['dv']); ?></p>
                            <p class="por"><?php echo ucwords($cliente['direccion']); ?>, <?php echo ucwords($cliente['comuna']); ?>, <?php echo ucwords($cliente['ciudad']); ?></p>
                            <!-- <p class="name_client">Ejecutivo <?php echo ucwords($cliente['rel_ejecutivo_id']); ?> - Cliente <?php echo ucwords($cliente['id']); ?></p>  -->
                        </address>
                    </div>
                    <div class="col-xs-12 text-center text-blue-aic">
                        <address class="por">
                            <strong class="por">Cierre Cartola:</strong><br>
                            <?php echo $fecha_cartola->format('d-m-Y'); ?>
                        </address>
                    </div>
                    
                
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
        <?php if (count($fondos) > 2) { ?>
            <?php foreach ($fondos as $fondo) {
                if (isset($fondo['nombre_largo']) && !empty(trim($fondo['nombre_largo']))) {
                    echo '<p style="page-break-before: always;"></p>';
                  
                    ?>

                        <div class="row">
                                
                                <div class="col-xs-12 page-break" >
                                    <h3 class="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">1) FONDOS DE INVERSIÓN / SOCIEDADES</h3>

                                </div>
                        </div>

                        <div class="row text-blue-aic fondo-encabezado rounded-cartola px-3" style="padding-bottom: 30px;margin-top: 10px;padding-top: 20px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title fondo-cartola rounded-cartola p-h3 text-blue-aic d-inline-block"><strong><?php echo strtoupper($fondo['nombre_largo']); ?></strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="">
                                        <table class="table table-striped">
                                            <thead>
                                            <!-- <tr>
                                                <th class="text-center"><strong>Fecha</strong></th>
                                                <th class="text-center"><strong>Concepto</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Nº Acciones':'Nº Cuotas';?></strong></th>
                                                <th class="text-center"><strong>Valor <?=($fondo['categoria'] != 'fip')?'Acción':'Cuota';?> a la Fecha</strong></th>
                                                <th class="text-center"><strong>Monto (<?=(($fondo['moneda'] == 'USD')||($fondo['moneda'] == 'EUR'))?$fondo['moneda']:'CLP';?>)</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Saldo de Acciones Nº':'Saldo de Cuotas Nº';?></strong></th>
                                            </tr> -->
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

                                                        

                                                
                                                
                                                $valor_uf_estimada = $fondo['avance_proyecto'][0]['uf_estimada']; //Agregar UF
                                                

                                                foreach ($fondo['movimientos'] as $movimiento)
                                                {
                                                        /* echo "<pre>";
                                                        var_dump($movimiento);
                                                        echo "</pre>"; */
                                                        
                                                    if ($movimiento['concepto'] == 'Aporte') {

                                                    ?>
                                                    <tr>
                                                        <?php $fecha_movimiento = date_create($movimiento['fecha']); ?>
                                                        <!-- <td class="text-center"><?php echo  date_format($fecha_movimiento, 'd-m-Y'); ?></td> --> <!-- Fecha -->
                                                        <!-- <td class="text-center"><?php echo  $movimiento['concepto']; ?></td> --> <!-- Concepto --> 
                                                        <?php }                                                        ?>
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
                                                            if($movimiento['monto_uf' > 0]){
                                                                $pago_dividendo = $pago_dividendo + $movimiento['monto_uf']; 
                                                            }else{
                                                                $pago_dividendo = $pago_dividendo - $movimiento['monto_uf'];
                                                            }
                                                            if($movimiento['monto_clp'] > 0){
                                                            $pago_dividendo_clp = $pago_dividendo_clp + $movimiento['monto_clp'];}
                                                            else{
                                                                $pago_dividendo_clp = $pago_dividendo_clp - $movimiento['monto_clp'];
                                                            }
                                                        }
                                                       

                                                        ?>
                                                        <?php
                                                        if ($movimiento['concepto'] != 'Aporte' && $movimiento['concepto'] != 'Pagaré' && $movimiento['concepto'] != 'Dev. Capital' && $movimiento['concepto'] != 'Pago Dividendo' && $movimiento['concepto'] != 'Dev. Reajuste Capital') {  //valores cartola
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

                                        <?php 
                                          
                                          
                                          
                                         

                                          

                                         

                                          $roe = 0;

                                          $ser=null;

                                          $post_venta = $fondo['avance_proyecto'][0];

                                                        /*echo "<pre>";
                                                        var_dump($post_venta);
                                                        echo "</pre>";*/


                                                        $this->load->model('intranet/fip');
                                                        $this->load->model('intranet/Aportesfip');
                                                        $fip = (new Fip())->getById($post_venta['rel_fip_id']);
                                                        $aportesFip = (new Aportesfip())->getById($fondo['aporte_id']);
                                                        $grupo = $aportesFip->getGrupofondoaporte();
                                                        if($fip->is_multi_calls){
                                                            $call = $aportesFip->getCall();
                                                            $ser = $call->getSeries();
                                                        }else{
                                                            $ser = $fip->getSeries();
                                                        }

                                        

                                          /*$this->load->model('intranet/fip');
                                          $this->load->model('intranet/Aportesfip');
                                          $fipfond = (new Fip())->getById($post_venta['rel_fip_id']);
                                          $aportesFipfond = (new Aportesfip())->getById($fondo['aporte_id']);
                                          $grupofond = $aportesFipfond->getGrupofondoaporte();
                                          $ser = $fipfond->getSeries();*/

                                          /*echo "<pre>";
                                          var_dump($post_venta);
                                          echo "</pre>";*/

                                                        
                                          
                                          

                                                                    if ($suma_acciones >= $ser[0]->minimo && $suma_acciones <= $ser[0]->maximo) {
                                                                        $roe = $post_venta['roe_serie_a'];
                                                                   } else if (isset($ser[1]) && $suma_acciones >= $ser[1]->minimo && $suma_acciones <= $ser[1]->maximo) {
                                                                        $roe = $post_venta['roe_serie_b'];                                                                       
                                                                    } else if (isset($ser[2]) && $suma_acciones >= $ser[2]->minimo && $suma_acciones <= $ser[2]->maximo) {
                                                                        $roe = $post_venta['roe_serie_c'];
                                                                    } else {
                                                                        if(isset($ser[3])) {
                                                                            $roe = $post_venta['roe_serie_d'];
                                                                           }       
                                                                    }
                                         
                                        

                                         
                                         
                                                                                                                               
                                                       
                                                       
                                        
                                                        
                                        ?>

                                       
                                        

                                                    
                                             

                                                                             
                                        
                                        <!-- hcvSF3xZE7FspNLepU4s --> <!-- Código Bit -->

                                        <!-- <table class="table table-bordered ">
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
                                        </table> -->

                                        <?php

                                                    
                                                                 $rent = $roe/100; 

                                                                    /*echo "<pre>";
                                                                    var_dump($rent);
                                                                    echo "</pre>";*/
                                        
                                                                 $div_esp = $suma_acciones * $rent;



                                                                 $inversion_inicial_uf = $suma_acciones;

                                                                                       
                                                                 $dev_total = $suma_acciones + $suma_acciones * $rent; 

                                                                 $valor_dif = 1 + $rent;

                                                                 if($rent < 0)
                                                                 {                                                                    
                                                                    $dev_total = ($suma_acciones * $valor_dif);
                                                                    $suma_acciones = $suma_acciones * $valor_dif;
                                                                 }
                        
                                                                 $dev_total_clp =0;

                                                                                                                                
                                                                 $capital_por_recibir = $suma_acciones - $capital_devuelto; 
                                                                 
                                                                                                                               
                                                                                                                         
                                                                $valor_cuota = $resumen['valor_cuota'];

                                                                $saldo_contable = $resumen['saldo_contable'];

                                                                $dev_esperad_pesos = ($div_esp - $pago_dividendo) * $valor_uf_estimada + $pago_dividendo_clp + $capital_por_recibir * $valor_uf_estimada + $capital_devuelto_clp;

                                                                if($rent < 0)
                                                                {
                                                                    $dev_esperad_pesos = $dev_total * $valor_uf_estimada;
                                                                }

                                                                $div_esperad_pesos = $div_esp * $valor_uf_estimada;

                                                                $cap_por_rec_pesos = $capital_por_recibir * $valor_uf_estimada;

                                                                    /*echo "<pre>";
                                                                    var_dump($cap_por_rec_pesos);
                                                                    echo "</pre>";*/  

                                                                $div_esperad_por_rec = $div_esp - $pago_dividendo;

                                                                $div_esperad_por_rec_pesos = ($div_esp - $pago_dividendo) * $valor_uf_estimada;

                                                                $fecha_formateada_inicio = date("d-m-y", strtotime($post_venta['fecha_inicio']));
                                                               
                                                                $fecha_formateada_fin = date("d-m-y", strtotime($post_venta['fecha_real_proyectada_cierre']));

                                                             
                                                                

                                                                if($fondo['moneda']=="UF")
                                                                {
                                                                    $resumen_dev[$post_venta['rel_fip_id']] = $dev_esperad_pesos;
                                                                    $resumen_ii[$post_venta['rel_fip_id']] = $suma_acciones_clp;
                                                                    $resumen_devuleto[$post_venta['rel_fip_id']] = $capital_devuelto_clp + $pago_dividendo_clp;
                                                                    $resumen_por_recibir[$post_venta['rel_fip_id']] = $dev_esperad_pesos - $capital_devuelto_clp - $pago_dividendo_clp;

                                                                }else if(($fondo['moneda']=="USD") || ($fondo['moneda']=="EUR")){

                                                                    $resumen_dev[$post_venta['rel_fip_id']] = $dev_total;
                                                                    $resumen_ii[$post_venta['rel_fip_id']] = $suma_acciones;
                                                                    $resumen_devuleto[$post_venta['rel_fip_id']] = $capital_devuelto + $pago_dividendo;
                                                                    $resumen_por_recibir[$post_venta['rel_fip_id']] = $dev_total - $capital_devuelto - $pago_dividendo;

                                                                }else{
                                                                    $resumen_dev[$post_venta['rel_fip_id']] = $suma_acciones_clp;
                                                                    $resumen_ii[$post_venta['rel_fip_id']] = $suma_acciones_clp;
                                                                    $resumen_devuleto[$post_venta['rel_fip_id']] = $capital_devuelto_clp + $pago_dividendo_clp;
                                                                    $resumen_por_recibir[$post_venta['rel_fip_id']] = $suma_acciones_clp - $capital_devuelto_clp - $pago_dividendo_clp;
                                                                }

                                                                     
                                                               
                                                    
                                                        
                                                        /*echo "<pre>";
                                                        var_dump($post_venta);
                                                        var_dump($roe);
                                                        echo "</pre>"; */                
                                                        
                                                                
                                                        
                                        ?>
                                                                             
                                      
                                        <div class="col-xs-12" >

                                        <?php if($fondo['moneda']=="UF"){  ?> 
                                        <div class="col-xs-12">
                                            <font size="1">
                                            <table class="table rounded-cartola table-bordered text-blue-aic fondo-cartola-claro">
                                                <thead class="thead-dark text-white">
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>MONTO EN UF</th>
                                                        <th>MONTO EN PESOS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    <tr>
                                                        <td>Inversión Inicial</td>
                                                        <td><?= number_format($inversion_inicial_uf, 2,',','.'); ?></td>
                                                        <td><?= number_format($suma_acciones_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                   
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td><?= number_format($roe, 1,',','.'); ?> %</td>
                                                        <td>--</td>
                                                    </tr>
                                                    
                                                        
                                                    <tr>
                                                        <td>Devolución Total Esperada</td>
                                                        <td><?= number_format($dev_total, 2,',','.'); ?></td>
                                                        <td><?= number_format($dev_esperad_pesos, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados</td>
                                                        <td><?= number_format($div_esp = ($div_esp >0) ? $div_esp: "0", 2,',','.'); ?></td>
                                                        <td><?= number_format($div_esperad_pesos = ($div_esperad_pesos >=0) ? $div_esperad_pesos : "0" , 0,',','.'); ?></td>
                                                    </tr>
                                                   
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital Devuelto</td>
                                                        <td><?= number_format($capital_devuelto, 2,',','.'); ?></td>
                                                        <td><?= number_format($capital_devuelto_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital por Recibir</td>
                                                        <td><?= number_format($capital_por_recibir, 2,',','.'); ?></td>
                                                        <td><?= number_format($cap_por_rec_pesos = ($cap_por_rec_pesos >=0) ? $cap_por_rec_pesos : "0", 0,',','.'); ?></td>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <td>Dividendos Devueltos</td>
                                                        <td><?= number_format($pago_dividendo, 2,',','.'); ?></td>
                                                        <td><?= number_format($pago_dividendo_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados por Recibir</td>
                                                        <td><?= number_format($div_esperad_por_rec = ($div_esperad_por_rec >0) ? $div_esperad_por_rec : "0", 2,',','.'); ?></td>
                                                        <td><?= number_format($div_esperad_por_rec_pesos = ($div_esperad_por_rec_pesos >=0) ? $div_esperad_por_rec_pesos : "0" , 0,',','.'); ?></td>
                                                    </tr>
                                                   
                                                    <tr class="tr-fondo-capital">
                                                        <td>Valor Cuota</td>
                                                        <td>--</td>
                                                        <td><?= number_format($valor_cuota, 2,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Saldo Contable</td>
                                                        <td>--</td>
                                                        <td><?= number_format($saldo_contable, 0,',','.'); ?></td>
                                                    </tr> 

                                                    <tr>
                                                        <td>Fecha Inicio Fondo</td>
                                                        <td><?= $fecha_formateada_inicio; ?></td>
                                                        <td>--</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Fecha estimada Cierre Fondo</td>
                                                        <td><?= $fecha_formateada_fin; ?></td>
                                                        <td>--</td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                            </font>
                                        </div>

                                            <?php if($roe >0){ ?>
                                                <center><p>RETORNO ESPERADO EN %</p></center> 
                                                
                                                <center><div class="reportGraph"><div class="mb-1 text-right" style="width: 600px;"><?=$roe."%"?></div> <canvas id="canvas<?= $cont_graphic; ?>"></canvas></div></center>

                                             <?php } ?>
                                        
                                        <?php } else if(($fondo['moneda']=="USD")||($fondo['moneda']=="EUR")){  ?> 

                                        <div class="col-xs-12">
                                            <font size="1">
                                            <table class="table rounded-cartola table-bordered fondo-cartola-claro text-blue-aic">
                                                <thead class="thead-dark text-white">
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>MONTO EN <?=$fondo['moneda']?></th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Inversión Inicial</td>
                                                        <td><?= number_format($inversion_inicial_uf, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    
                                                   
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td><?= number_format($roe, 1,',','.'); ?> %</td>
                                                        
                                                    </tr>
                                                    
                                                                                                          
                                                    <tr>
                                                        <td>Devolución Total Esperada</td>
                                                        <td><?= number_format($dev_total, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados</td>
                                                        <td><?= number_format($div_esp = ($div_esp >0) ? $div_esp: "0", 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital Devuelto</td>
                                                        <td><?= number_format($capital_devuelto, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital por Recibir Esperados</td>
                                                        <td><?= number_format($capital_por_recibir = ($capital_por_recibir >=0)? $capital_por_recibir : "0", 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Devueltos</td>
                                                        <td><?= number_format($pago_dividendo, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados por Recibir</td>
                                                        <td><?= number_format($div_esp - $pago_dividendo, 2,',','.'); ?></td>
                                                       
                                                    </tr>
                                                   <tr class="tr-fondo-capital">
                                                        <td>Valor Cuota</td>
                                                        <td><?= number_format($resumen['valor_cuota'], 2,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Saldo Contable</td>
                                                        <td><?= number_format($resumen['saldo_contable'], 0,',','.'); ?></td>
                                                    </tr> 

                                                    <tr>
                                                        <td>Fecha Inicio Fondo</td>
                                                        <td><?= $fecha_formateada_inicio; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Fecha estimada Cierre Fondo</td>
                                                        <td><?= $fecha_formateada_fin; ?></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                            </font>
                                        </div>
                                            
                                            <?php if($roe >0){ ?>
                                                <center><p>RETORNO ESPERADO EN %</p></center>
                                                <center><div class="reportGraph"><div class="mb-1 text-right" style="width: 600px;"><?=$roe."%"?></div> <canvas id="canvas<?= $cont_graphic; ?>"></canvas></div></center>
                                                
                                             <?php } ?>
                                        
                                             <?php } else { ?>

                                        <div class="col-xs-12">
                                            <font size="1">
                                            <table class="table rounded-cartola table-bordered fondo-cartola-claro text-blue-aic">
                                                <thead class="thead-dark text-white">
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>MONTO EN PESOS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Inversión Inicial</td>
                                                        <td><?= number_format($suma_acciones_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                                                                      
                                                   
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td><?= number_format($roe, 1,',','.'); ?> %</td>
                                                        
                                                    </tr>
                                                   
                                                                                                           
                                                    <tr>
                                                        <td>Devolución Total Esperada</td>
                                                        <td><?= number_format($suma_acciones_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados</td>
                                                        <td><?= number_format($suma_acciones_clp * $rent, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital Devuelto</td>
                                                        <td><?= number_format($capital_devuelto_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital por Recibir Esperados</td>
                                                        <td><?= number_format($suma_acciones_clp - $capital_devuelto_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Devueltos</td>
                                                        <td><?= number_format($pago_dividendo_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados por Recibir</td>
                                                        <td><?= number_format($suma_acciones_clp*$rent - $pago_dividendo_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td >Valor Cuota</td>
                                                        
                                                        <td><?= number_format($resumen['valor_cuota'], 2,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Saldo Contable</td>
                                                        
                                                        <td><?= number_format($resumen['saldo_contable'], 0,',','.'); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Fecha Inicio Fondo</td>
                                                        <td><?= $fecha_formateada_inicio; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Fecha estimada Cierre Fondo</td>
                                                        <td><?= $fecha_formateada_fin; ?></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                            </font>
                                        </div>
                                       
                                            <?php if($roe >0){ ?>
                                                <center><p>RETORNO ESPERADO EN %</p></center>
                                                <center><div class="reportGraph"><div class="mb-1 text-right" style="width: 600px;"><?=$roe."%"?></div> <canvas id="canvas<?= $cont_graphic; ?>"></canvas></div></center>
                                             <?php } ?>

                                             <?php } ?>

                                            
                                        </div>


<style>
    .reportGraph {width:600px}
</style>
<?php
$fecha_inicio = $post_venta['fecha_inicio'];
$f_i_e = explode("-", $fecha_inicio);

$fecha_fin = $post_venta['fecha_real_proyectada_cierre'];
$f_f_e = explode("-", $fecha_fin);
?>
<script type="text/javascript">
// wkhtmltopdf 0.12.5 crash fix.
// https://github.com/wkhtmltopdf/wkhtmltopdf/issues/3242#issuecomment-518099192
'use strict';
(function(setLineDash) {
    CanvasRenderingContext2D.prototype.setLineDash = function() {
        if(!arguments[0].length){
            arguments[0] = [1,0];
        }
        // Now, call the original method
        return setLineDash.apply(this, arguments);
    };
})(CanvasRenderingContext2D.prototype.setLineDash);
Function.prototype.bind = Function.prototype.bind || function (thisp) {
    var fn = this;
    return function () {
        return fn.apply(thisp, arguments);
    };
};
function drawGraphs<?php echo $cont_graphic; ?>() {
    new Chart(
        document.getElementById("canvas<?php echo $cont_graphic; ?>"), {
            "responsive": false,
            "type":"line",
            "data":{
                "labels":["<?php echo $f_i_e[0]; ?>","<?php echo $f_f_e[0]; ?>"],
                "datasets":[{
                    "label":"RETORNO ESPERADO EN %",
                    "data":[0, <?php echo $roe; ?>],
                    "fill":false,
                    "borderColor":"rgb(0, 192, 239)",
                    "borderDash":[15, 10]
                }]
            },
            "options":{  "legend": {
                    "display": false // Cambia esto a "false" si deseas ocultar la leyenda completa
                }
                    
             }
        }
    );
};
window.onload = function() {
    drawGraphs<?php echo $cont_graphic; ?>();
};
drawGraphs<?php echo $cont_graphic; ?>();
</script>      

                                         <script>
                                                          
                                            

                                                        Highcharts.chart('container<?= $cont_graphic; ?>', {

                                                            
                                                            
                                                        title: {
                                                        text: 'RETORNO ESPERADO',
                                                        align: 'left'
                                                        },

                                                        
                                                        yAxis: {
                                                            title: {
                                                            text: '',
                                                            min: 0,
                                                            max: <?= $roe;?>,
                                                            style: {
                                                                fontSize: '14px', // Aquí especificas el tamaño de letra deseado.
                                                            },
                                                            },
                                                            labels: {
                                                                format: '{value}%',
                                                            style: {
                                                                fontSize: '14px', // Aquí especificas el tamaño de letra deseado para las categorías.
                                                            },
                                                            },
                                                            ticks: {
            
                   min: 0,
                   max: 100,
                   callback: function(value){return value+ "%"}
                }
                                                        },

                                                      

                                                         xAxis: {
                                                                    type: 'datetime',
                                                                    tickInterval: 365 * 24 * 3600 * 1000, // Intervalo de 1 día en milisegundos
                                                                    min: new Date('<?=$post_venta['fecha_inicio'];?>').getTime(),
                                                                    max: new Date('<?=$post_venta['fecha_real_proyectada_cierre'];?>').getTime(),
                                                                    labels: {
                                                                        format: '{value}%dd',
                                                                        style: {
                                                                            fontSize: '14px', // Aquí especificas el tamaño de letra deseado para las categorías.
                                                                        },
                                                                    },
                                                                    dateTimeLabelFormats: {
                                                                    day: '%e %b', // Formato para días: "15 Jul"
                                                                    week: '%e %b', // Formato para semanas: "15 Jul"
                                                                    month: '%b \'%y', // Formato para meses: "Jul '23"
                                                                    year: '%Y' // Formato para años: "2023"
                                                                    }, 
                                                                    
                                                                },

                                                        legend: {
                                                           
                                                            enabled: false
                                                        },

                                                        exporting: {
                                                            enabled: false, // Deshabilitar el menú con las opciones de exportación.
                                                        },

                                                        plotOptions: {
                                                            series: {
                                                                enableMouseTracking: false,
                                                                shadow: false,
                                                                animation: false,              
                                                            dataLabels: {
                                                                enabled: false, // Deshabilitar las etiquetas de los puntos de datos en todas las series.
                                                            }
                                                            }
                                                        },

                                                        series: [{
                                                        name: '',
                                                        data: [[new Date('<?=$post_venta['fecha_inicio'];?>').getTime(),0],
                                                                [new Date('<?=$post_venta['fecha_real_proyectada_cierre'];?>').getTime(),<?= $roe;?>]
                                                                ],
                                                        dashStyle: 'Dash',
                                                        lineWidth: 3,
                                                        dataLabels: {
                                                        format: '{y}%',
                                                        enabled: true, // Habilitar las etiquetas de los puntos de datos.
                                                        align: 'right', // Alinear las etiquetas a la derecha del punto de datos.
                                                        showInLegend: false, // Ocultar la serie en la leyenda.
                                                        x: -10, // Desplazar las etiquetas 10 píxeles hacia la izquierda para que estén al final de la línea.
                                                        style: {
                                                            fontSize: '14px', // Tamaño de letra deseado para el texto de la serie.
                                                        },
                                                        },
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
                                                        },
                                                        options: {
        scales: {
            yAxes: [{
            ticks: {
                   min: 0,
                   max: 100,
                   callback: function(value){return value+ "%"}
                },
                        scaleLabel: {
                   display: true,
                   labelString: "Percentage"
                }
            }]
        }
    }
                                                      
                                                        });

                                            </script>
                                          
                                                    <?php 
                                                      $cont_graphic++;
                                                      $roe =0;
                                                      $most_rent =0; 
                                                      
                                                      ?>                                                      



                                        <? if(count($fondo['avance_proyecto']) > 0) {

                                            $avance_proyecto = $fondo['avance_proyecto'][0];

                                            if ($avance_proyecto['mostrar_grafico_cartola'] == 1) {
                                                ?>
                                                <table class="table table-condensed">
                                                    <tr>
                                                        <td colspan="6"><h5><u>Indicadores del Proyecto</u></h5></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h5>1.- Avance del Proyecto</h5>
                                                        </td>
                                                        <td colspan="1">
                                                            <h5 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h5>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="semaforo vcenter">
                                                                <?
                                                                if ($avance_proyecto['atraso_meses'] <= 3) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/green-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                                <?php
                                                                if ($avance_proyecto['atraso_meses'] > 3 && $avance_proyecto['mostrar_rojo'] == 0) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/yellow-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                                <?php
                                                                if ($avance_proyecto['atraso_meses'] > 3 && $avance_proyecto['mostrar_rojo'] == 1) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/red-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                            </div>
                                                        </td>
                                                        <td colspan="1">
                                                            <table class="">
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/green-dot.png') ?>"
                                                                             width="9" height="9"/></td>
                                                                    <td>Proyecto avanzando de acuerdo a lo estimado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/yellow-dot.png') ?>"
                                                                             width="9" height="9"/></td>
                                                                    <td>Proyecto avanzando más lento a lo estimado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/red-dot.png') ?>"
                                                                             width="9" height="9"/></td>
                                                                    <td>Proyecto con problemas en su desarrollo</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h5>2.- Progreso Estimado</h5>
                                                        </td>
                                                        <td colspan="1">
                                                            <h5 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h5>
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
                                                            <td colspan="6"><h5><u>Indicadores del Proyecto</u></h5></td>
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
                                                            <h5 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h5>
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
                                                                                    $rentabilidad = 0;

                                                                                } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $aux_avance_proyecto['roe_serie_b'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_b'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[1]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
                                                                                } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $aux_avance_proyecto['roe_serie_c'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_c'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[2]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
                                                                                } else {
                                                                                    if(isset($series[3])) {
                                                                                        /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $aux_avance_proyecto['roe_serie_d'];*/
                                                                                        $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                            echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                        }else {
                                                                                               echo '' . $series[3]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                              }
                                                                                              $rentabilidad = 0;
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
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else {
                                                                        if(isset($series[3])) {
                                                                            /*$rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];*/
                                                                            $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';

                                                                            }
                                                                            $rentabilidad = 0;
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
                                                                                    $rentabilidad = 0;
                                                                                } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $aux_avance_proyecto['roe_serie_b'];


                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_b'];
                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[1]->serie . ' &nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
                                                                                } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $aux_avance_proyecto['roe_serie_c'];
                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_c'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[2]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
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
                                                                                    $rentabilidad = 0;
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
                                                                            $rentabilidad = 0;
                                                                        } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                            $rentabilidad = 0;
                                                                        } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                            $rentabilidad = 0;
                                                                        } else {
                                                                            if(isset($series[3])) {
                                                                                $rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];


                                                                                if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                    echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                                }else {
                                                                                    echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';

                                                                                }
                                                                            }
                                                                            $rentabilidad = 0;
                                                                            
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
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else {
                                                                        if(isset($series[3])) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                                  }
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </td>
                                                    </tr> <!-- Prueba Datos -->
                                                    <tr>

                                                    <div class="col-xs-12">
                                                            <?php //echo "<pre>"; var_dump($avance_proyecto); echo "</pre>"; 

                                                                $most_rent = $rentabilidad;  
                                                                                                                               
                                                                $rentabilidad = $most_rent/100; //rentabilidad del fondo
                                                                
                                                                $inversion_inicial_uf = $suma_acciones; //suma de aportes 
                                                               
                                                                $inversion_inicial_clp = $suma_acciones_clp;
                                                                
                                                                $saldo_capital_entregado_uf = $capital_devuelto;
                                                                
                                                                $saldo_capital_entregado_clp = $capital_devuelto_clp;
                                                                
                                                                $dividendos_esperados_uf = $inversion_inicial_uf * $rentabilidad;

                                                                $dividendos_esperados_clp = $pago_dividendo_clp + $dividendos_esperados_uf * $valor_uf_estimada;
                                                                
                                                                $monto_capital_por_recibir_uf = $inversion_inicial_uf - $saldo_capital_entregado_uf;

                                                                $monto_dividendos_por_recibir_clp = $dividendos_esperados_uf * $valor_uf_estimada;
                                                                
                                                                $monto_capital_por_recibir_clp = $monto_capital_por_recibir_uf * $valor_uf_estimada;

                                                                $dividendos_total_clp = $pago_dividendo_clp + $monto_dividendos_por_recibir_clp;
                                                                
                                                                $saldo_dividendos_entregados_clp = $pago_dividendo_clp;
                                                                                                         
                                                                $saldo_dividendos_entregados_uf = $pago_dividendo;
                                                                                                                          
                                                                $monto_dividendos_por_recibir_uf = $dividendos_esperados_uf - $saldo_dividendos_entregados_uf;
                                                                                                                     
                                                                $devolucion_total_uf_esp = $inversion_inicial_uf + ($inversion_inicial_uf*$rentabilidad); //estimacion de la devolución

                                                                                                                                
                                                                $devolucion_total_clp_esp = 0; //suma de capitales y dividendos

                                                                if($capital_devuelto_clp > $inversion_inicial_clp){
                                                                    $devolucion_total_clp_esp = $capital_devuelto_clp + $dividendos_total_clp;
                                                                }else{
                                                                    $devolucion_total_clp_esp = $saldo_capital_entregado_clp + $monto_capital_por_recibir_clp + $dividendos_total_clp;
                                                                }
                                                                
                                                           
                                                                $valor_cuota = $resumen['valor_cuota'];

                                                                $saldo_contable = $resumen['saldo_contable'];
                                                                
                                                            ?>
                                                                       <!-- hcvSF3xZE7FspNLepU4s --> <!-- Código Bit  -->
                                                                        
                                                                            
                                                                            

                                                                                                                                                                      
                                                                
                                                               
                                                            </div>

                                                    </tr>

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
                                    <div class="alert alert-grey">
                                        <strong>Nota:</strong>
                                        <ol>
                                            <li><p align="justify">El valor cuota a la fecha de esta cartola es referencial, y está basado en el valor contable del patrimonio del Fondo o Sociedad, donde la inversión en el proyecto está reflejada a su valor histórico y no en base al Valor Económico del Proyecto.</p></li>
                                            <?php if($fondo['moneda']== 'UF'){ ?>
                                            <li><p align="justify">Todas las estimaciones de devolución de capital y dividendos son calculadas en pesos en función de las estimaciones de inflación que hace el Banco Central de Chile en su IPOM y son ajustados trimestralmente.</p></li>
                                            <?php }?>
                                            <?if(isset($series) && count($series) > 0 && $avance_proyecto['mostrar_roe']== 1):?>
                                            <li><p>El indicador de Retorno Estimado es una proyección efectuada con la información proporcionada por la Inmobiliaria Gestora del proyecto y algunos supuestos propios.</p></li>
                                            <? endif; ?>
                                            <?if(isset($fondo['comentario'])):?>
                                            <li><p align="justify"><?=$fondo['comentario'];?></p></li>
                                            <?endif;?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <br>
                        
                    <?php
                }
                
                //echo '<p style="page-break-after: always;"></p>'; 
                
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
        
        <?php echo '<p style="page-break-before: always;"></p>'; ?>
        
        <div class= "row text-blue-aic fondo-encabezado rounded-cartola px-3" style="margin-bottom: 100px;padding-bottom: 30px;margin-top: 25px;">
            <div class="col-xs-12">
                <h3 class="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">RESUMEN</h3>
            </div>
                       
            <?php if (count($fondos) > 2) { ?>
            <div class="col-xs-12">
                <div class="">
                    <?foreach($resumenes_saldos as $k => $resumenes_saldo):?>
                        <? if($k == 'USD'): ?>
                        <div class="row">
                            <div class="col-xs-12">
                                
                                 <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN DÓLARES</h4>

                               

<table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title margen-texto">

    <thead class="thead-dark text-white">
        <tr>
            <th class="col-md-8"></th>
            <th class="col-md-2 text-center">Inversión Inicial</th>
            <th class="col-md-2 text-center">Devolución Total Esperada</th>
            <th class="col-md-2 text-center">Total Devuelto</th>
            <th class="col-md-2 text-center">Total por Devolver Esperado</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $sumaPorcentajePatrimonio = 0;
        $sumaPatrimonio = 0;

        foreach($resumenes_saldo as $resumen){
            $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
        }

        $suma_devoluciones = 0;
        $suma_inversiones = 0;
        $suma_por_recibir = 0;
        $suma_recibido = 0;

       

        if(!empty($resumenes_saldos)){

            foreach ($resumenes_saldo as $resumen) {
                 ?>
                <tr>
                <td><?= strtoupper($resumen['nombre_largo']) ?></td>
                <td class="text-center">USD <?= number_format($resumen_ii[$resumen['id']], 0,',','.') ?></td>
                <td class="text-center">USD <?= number_format($resumen_dev[$resumen['id']], 0,',','.') ?></td>
                <td class="text-center">USD <?= number_format($resumen_devuleto[$resumen['id']], 0,',','.') ?></td>
                <td class="text-center">USD <?= number_format($resumen_por_recibir[$resumen['id']], 0,',','.') ?></td>
                <?php
                $suma_devoluciones = $suma_devoluciones + $resumen_dev[$resumen['id']];
                $suma_inversiones = $suma_inversiones + $resumen_ii[$resumen['id']];
                $suma_recibido = $suma_recibido + $resumen_devuleto[$resumen['id']];
                $suma_por_recibir = $suma_por_recibir + $resumen_por_recibir[$resumen['id']];

                ?>
               
                
            </tr>
            <?php
            }
        } 
        ?>
    </tbody>

    <tfoot>
        <tr style="border-top-color: #0a0a0a !important;">
            <td class="text-right">
                <strong>Total</strong>
            </td>

            <td class="text-center">
                <strong>USD <?= number_format($suma_inversiones,0, ',','.' ) ?></strong>
            </td>

            <td class="text-center">
                <strong>USD <?= number_format($suma_devoluciones,0, ',','.' ) ?></strong>
            </td>
           
            <td class="text-center">
                <strong>USD <?= number_format($suma_recibido,0, ',','.' ) ?></strong>
            </td>
            <td class="text-center">
                <strong>USD <?= number_format($suma_por_recibir,0,',','.') ?> </strong>
            </td>
        </tr>
    </tfoot>

</table>

</div>
</div>
<? elseif($k == 'EUR'): ?>
    <div class="row">
                            <div class="col-xs-12">
                                
                                 <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN EUROS</h4>

                                 <table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title margen-texto">

<thead class="thead-dark text-white">
    <tr>
        <th class="col-md-8"></th>
        <th class="col-md-2 text-center">Inversión Inicial</th>
        <th class="col-md-2 text-center">Devolución Total Esperada</th>
        <th class="col-md-2 text-center">Total Devuelto</th>
        <th class="col-md-2 text-center">Total por Devolver Esperado</th>
    </tr>
</thead>

<tbody>
<?php
    $sumaPorcentajePatrimonio = 0;
    $sumaPatrimonio = 0;

    foreach($resumenes_saldo as $resumen){
        $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
    }

    $suma_devoluciones = 0;
    $suma_inversiones = 0;
    $suma_por_recibir = 0;
    $suma_recibido = 0;

   

    if(!empty($resumenes_saldos)){

        foreach ($resumenes_saldo as $resumen) {
             ?>
            <tr>
            <td><?= strtoupper($resumen['nombre_largo']) ?></td>
            <td class="text-center">EUR <?= number_format($resumen_ii[$resumen['id']], 0,',','.') ?></td>
            <td class="text-center">EUR <?= number_format($resumen_dev[$resumen['id']], 0,',','.') ?></td>
            <td class="text-center">EUR <?= number_format($resumen_devuleto[$resumen['id']], 0,',','.') ?></td>
            <td class="text-center">EUR <?= number_format($resumen_por_recibir[$resumen['id']], 0,',','.') ?></td>
            <?php
            $suma_devoluciones = $suma_devoluciones + $resumen_dev[$resumen['id']];
            $suma_inversiones = $suma_inversiones + $resumen_ii[$resumen['id']];
            $suma_recibido = $suma_recibido + $resumen_devuleto[$resumen['id']];
            $suma_por_recibir = $suma_por_recibir + $resumen_por_recibir[$resumen['id']];

            ?>
           
            
        </tr>
        <?php
        }
    } 
    ?>
</tbody>

<tfoot>
    <tr style="border-top-color: #0a0a0a !important;">
        <td class="text-right">
            <strong>Total</strong>
        </td>

        <td class="text-center">
            <strong>EUR <?= number_format($suma_inversiones,0, ',','.' ) ?></strong>
        </td>

        <td class="text-center">
            <strong>EUR <?= number_format($suma_devoluciones,0, ',','.' ) ?></strong>
        </td>
       
        <td class="text-center">
            <strong>EUR <?= number_format($suma_recibido,0, ',','.' ) ?></strong>
        </td>
        <td class="text-center">
            <strong>EUR <?= number_format($suma_por_recibir,0,',','.') ?> </strong>
        </td>
    </tr>
</tfoot>

</table>

</div>
</div>
<? elseif($k == 'CLP'): ?>
    <div class="row">
                            <div class="col-xs-12">
                                
                                 <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN PESOS</h4>

                                 <table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title margen-texto">

<thead class="thead-dark text-white">
    <tr>
        <th class="col-md-8"></th>
        <th class="col-md-2 text-center">Inversión Inicial</th>
        <th class="col-md-2 text-center">Devolución Total Esperada</th>
        <th class="col-md-2 text-center">Total Devuelto</th>
        <th class="col-md-2 text-center">Total por Devolver Esperado</th>
    </tr>
</thead>

<tbody>
<?php
    $sumaPorcentajePatrimonio = 0;
    $sumaPatrimonio = 0;

    foreach($resumenes_saldo as $resumen){
        $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
    }

    $suma_devoluciones = 0;
    $suma_inversiones = 0;
    $suma_por_recibir = 0;
    $suma_recibido = 0;

   

    if(!empty($resumenes_saldos)){

        foreach ($resumenes_saldo as $resumen) {
             ?>
            <tr>
            <td><?= strtoupper($resumen['nombre_largo']) ?></td>
            <td class="text-center"><?= number_format($resumen_ii[$resumen['id']], 0,',','.') ?></td>
            <td class="text-center"><?= number_format($resumen_dev[$resumen['id']], 0,',','.') ?></td>
            <td class="text-center"><?= number_format($resumen_devuleto[$resumen['id']], 0,',','.') ?></td>
            <td class="text-center"><?= number_format($resumen_por_recibir[$resumen['id']], 0,',','.') ?></td>
            <?php
            $suma_devoluciones = $suma_devoluciones + $resumen_dev[$resumen['id']];
            $suma_inversiones = $suma_inversiones + $resumen_ii[$resumen['id']];
            $suma_recibido = $suma_recibido + $resumen_devuleto[$resumen['id']];
            $suma_por_recibir = $suma_por_recibir + $resumen_por_recibir[$resumen['id']];

            ?>
           
            
        </tr>
        <?php
        }
    } 
    ?>
</tbody>

<tfoot>
    <tr style="border-top-color: #0a0a0a !important;">
        <td class="text-right">
            <strong>Total</strong>
        </td>

        <td class="text-center">
            <strong><?= number_format($suma_inversiones,0, ',','.' ) ?></strong>
        </td>

        <td class="text-center">
            <strong><?= number_format($suma_devoluciones,0, ',','.' ) ?></strong>
        </td>
       
        <td class="text-center">
            <strong><?= number_format($suma_recibido,0, ',','.' ) ?></strong>
        </td>
        <td class="text-center">
            <strong><?= number_format($suma_por_recibir,0,',','.') ?></strong>
        </td>
    </tr>
</tfoot>

</table>

</div>
</div>
<? else: ?>     
<div class="row">
<div class="col-xs-12">

                                <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN UF</h4>
                                <table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title margen-texto">

    <thead class="thead-dark text-white">
        <tr>
            <th class="col-md-8"></th>
            <th class="col-md-2 text-center">Inversión Inicial</th>
            <th class="col-md-2 text-center">Devolución Total Esperada</th>
            <th class="col-md-2 text-center">Total Devuelto</th>
            <th class="col-md-2 text-center">Total por Devolver Esperado</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $sumaPorcentajePatrimonio = 0;
        $sumaPatrimonio = 0;

        foreach($resumenes_saldo as $resumen){
            $sumaPatrimonio = $resumen['saldo_contable']+$sumaPatrimonio;
        }

        $suma_devoluciones = 0;
        $suma_inversiones = 0;
        $suma_por_recibir = 0;
        $suma_recibido = 0;

       

        if(!empty($resumenes_saldos)){

            foreach ($resumenes_saldo as $resumen) {
                 ?>
                <tr>
                <td><?= strtoupper($resumen['nombre_largo']) ?></td>
                <td class="text-center"><?= number_format($resumen_ii[$resumen['id']], 0,',','.') ?></td>
                <td class="text-center"><?= number_format($resumen_dev[$resumen['id']], 0,',','.') ?></td>
                <td class="text-center"><?= number_format($resumen_devuleto[$resumen['id']], 0,',','.') ?></td>
                <td class="text-center"><?= number_format($resumen_por_recibir[$resumen['id']], 0,',','.') ?></td>
                <?php
                $suma_devoluciones = $suma_devoluciones + $resumen_dev[$resumen['id']];
                $suma_inversiones = $suma_inversiones + $resumen_ii[$resumen['id']];
                $suma_recibido = $suma_recibido + $resumen_devuleto[$resumen['id']];
                $suma_por_recibir = $suma_por_recibir + $resumen_por_recibir[$resumen['id']];

                ?>
               
                
            </tr>
            <?php
            }
        } 
        ?>
    </tbody>

    <tfoot>
        <tr style="border-top-color: #0a0a0a !important;">
            <td class="text-right">
                <strong>Total</strong>
            </td>

            <td class="text-center">
                <strong><?= number_format($suma_inversiones,0, ',','.' ) ?></strong>
            </td>

            <td class="text-center">
                <strong><?= number_format($suma_devoluciones,0, ',','.' ) ?></strong>
            </td>
           
            <td class="text-center">
                <strong><?= number_format($suma_recibido,0, ',','.' ) ?></strong>
            </td>
            <td class="text-center">
                <strong><?= number_format($suma_por_recibir,0,',','.') ?></strong>
            </td>
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
<?php
$omar = '';
$cont_graphic = 0;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('fondo.php'); // Incluye el archivo PHP para generar el CSS dinámicamente ?>
    


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
        font-size: 1.5em;
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

        .letra{
            font-size: 1.5em;
        }

        .highcharts-data-table caption {
        padding: 2em 0;
        font-size: 2em;
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
            background-color: #D0CECE;
        }
        .rounded-cartola{
            border-radius: 7px;
        }
        .text-white{
            color:white;
        }

        .text-blue-aic{
            color:#0F2A3D;
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
            background-color: #D0CECE;
        }

        .thead-dark{
            background-color: #166EB6;
                       
        }

        .tr-fondo-capital{
            background-color: #D8D8D8;
                       
        }

        .tr-fondo-dividendos{
            background-color: #1d335c;
                       
        }

        .encabezados{
            background-color: #7462FA;            
        }

        .fondo-encabezado{
            background-color: white;
        }

        .px-3{
            padding-left: 3rem;
            padding-right: 3rem;            
        } 

        .por{
           font-size: 30px; /* Puedes ajustar el valor a tu preferencia */
        }

        .repor{
           font-size: 40px; /* Puedes ajustar el valor a tu preferencia */
        }



        .bod {
            display: flex;
            justify-content: center;
            align-items: center;
            
            
        }

        .cent{
            margin-bottom: center-block;
        }

        .page-break-up {
            page-break-before: always;
        }

        .page-break-down {
            page-break-after: always;
        }

        .page-break {
        page-break-before: always;
        }
              
          
        
        @media print {
            .container.well{
                opacity: 0;
                height: 1px;
                
            }
        }

    </style>

    <!-- <style>
        body {
            background-color: #103851;
            background-repeat: no-repeat;
            background-size: cover; /* Ajusta la imagen al tamaño del body */
            background-position: center; /* Posiciona la imagen en el centro del body */
        }
    </style>  -->

       
    <style>
         
        body {
            background: repeating-linear-gradient(90deg, #103851, #2a4e64 50%, #7a919f 75%, #FFFFFF 100%);
        }
        strong {
            text-transform: uppercase;
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
        <div class="well container">
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
                    <!-- <a href="<?=$this->config->item('API_URL')?>exportar/pdfCartola/<?=$cliente['key_encriptada'];?>/<?=$this->input->get('month');?>/<?php echo $this->input->get('year'); ?>" class="btn btn-info" target="_blank"> <i class="fa fa-file"></i> Exportar a PDF</a>  -->
                    <button class="btn btn-info" onclick="imprimir()"> <i class="fa fa-file"></i> Guardar en PDF</button>
                    <script>
                    function imprimir(){
                       if (window.print) {
                        window.print();
                       }
                    }
                </script>
                <?php }else{?>
                <a href="<?php echo current_url(); ?>" class="btn btn-default" target="_blank"> <i class="fa fa-print"></i> Versión para Imprimir</a>
                <!-- <a href="<?=$this->config->item('API_URL')?>exportar/pdfCartola/<?=$cliente['key_encriptada'];?>/<?=(int)$now->format('m') - 1;?>/<?=$now->format('Y');?>" class="btn btn-info" target="_blank"> <i class="fa fa-file"></i> Exportar a PDF</a> -->
                <button class="btn btn-info" onclick="imprimir()"> <i class="fa fa-file"></i> Guardar en PDF</button> 
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
             <p style="font-size: 0.5rem;
                  color: transparent;
                  ">.</p>
            </div>
        <div class="row text-blue-aic fondo-encabezado rounded-cartola px-3">

                             

            <div class="col-xs-12">
                 <div>
                   <center> <img id="logo" class="img-responsive pull-center mb-2 cent" src="<?php echo base_url('assets/img'); ?>/logotipo.png" alt="AICapitals"> </center>
                </div>

                
                
                <!-- <div class="clearfix"></div>
                 -->
                


                    <div class="col-xs-12 text-center por text-blue-aic">
                        <address>

                            <div class="invoice-title text-center">
                                <strong class="repor">REPORTE MENSUAL</strong><br>
                                <h3 class="repor"> <strong><?php echo strtoupper($meses[$fecha_cartola->format('m')-1]); ?> | <?php echo $fecha_cartola->format('Y'); ?></strong></h3><br><br>
                            </div>
                            
                            <strong class="por">Datos del Cliente:</strong><br>
                            <p class="por"><?php echo ucwords($cliente['nombre']); ?> <?php echo ucwords($cliente['seg_nombre']); ?> <?php echo ucwords($cliente['apellido']); ?> <?php echo ucwords($cliente['seg_apellido']); ?></p>
                            <p class="por"><?php echo number_format($cliente['rut'],0,',','.'); ?>-<?php echo ucwords($cliente['dv']); ?></p>
                            <p class="por"><?php echo ucwords($cliente['direccion']); ?>, <?php echo ucwords($cliente['comuna']); ?>, <?php echo ucwords($cliente['ciudad']); ?></p>
                            <!-- <p class="name_client">Ejecutivo <?php echo ucwords($cliente['rel_ejecutivo_id']); ?> - Cliente <?php echo ucwords($cliente['id']); ?></p>  -->
                        </address>
                    </div>
                    <div class="col-xs-12 text-center text-blue-aic">
                        <address class="por">
                            <strong class="por">Cierre Cartola:</strong><br>
                            <?php echo $fecha_cartola->format('d-m-Y'); ?>
                        </address>
                    </div>
                    
                
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
        <?php if (count($fondos) > 2) { ?>
            <?php foreach ($fondos as $fondo) {
                if (isset($fondo['nombre_largo']) && !empty(trim($fondo['nombre_largo']))) {
                    echo '<p style="page-break-before: always;"></p>';
                  
                    ?>

                    <div class="row">
                            
                            <div class="col-xs-12 page-break" >
                                <h3 class="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">1-FONDOS DE INVERSIÓN / SOCIEDADES</h3>

                            </div>
                        </div>

                        <div class="row text-blue-aic fondo-encabezado rounded-cartola px-3" style="padding-bottom: 30px;margin-top: 10px;padding-top: 20px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title fondo-cartola rounded-cartola p-h3 text-blue-aic d-inline-block"><strong><?php echo strtoupper($fondo['nombre_largo']); ?></strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="">
                                        <table class="table table-striped">
                                            <thead>
                                            <!-- <tr>
                                                <th class="text-center"><strong>Fecha</strong></th>
                                                <th class="text-center"><strong>Concepto</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Nº Acciones':'Nº Cuotas';?></strong></th>
                                                <th class="text-center"><strong>Valor <?=($fondo['categoria'] != 'fip')?'Acción':'Cuota';?> a la Fecha</strong></th>
                                                <th class="text-center"><strong>Monto (<?=(($fondo['moneda'] == 'USD')||($fondo['moneda'] == 'EUR'))?$fondo['moneda']:'CLP';?>)</strong></th>
                                                <th class="text-center"><strong><?=($fondo['categoria'] != 'fip')?'Saldo de Acciones Nº':'Saldo de Cuotas Nº';?></strong></th>
                                            </tr> -->
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
                                                        
                                                    if ($movimiento['concepto'] == 'Aporte') {

                                                    ?>
                                                    <tr>
                                                        <?php $fecha_movimiento = date_create($movimiento['fecha']); ?>
                                                        <!-- <td class="text-center"><?php echo  date_format($fecha_movimiento, 'd-m-Y'); ?></td> --> <!-- Fecha -->
                                                        <!-- <td class="text-center"><?php echo  $movimiento['concepto']; ?></td> --> <!-- Concepto --> 
                                                        <?php }                                                        ?>
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
                                                            if($movimiento['monto_uf' > 0]){
                                                                $pago_dividendo = $pago_dividendo + $movimiento['monto_uf']; 
                                                            }else{
                                                                $pago_dividendo = $pago_dividendo - $movimiento['monto_uf'];
                                                            }
                                                            if($movimiento['monto_clp'] > 0){
                                                            $pago_dividendo_clp = $pago_dividendo_clp + $movimiento['monto_clp'];}
                                                            else{
                                                                $pago_dividendo_clp = $pago_dividendo_clp - $movimiento['monto_clp'];
                                                            }
                                                        }
                                                       

                                                        ?>
                                                        <?php
                                                        if ($movimiento['concepto'] != 'Aporte' && $movimiento['concepto'] != 'Pagaré' && $movimiento['concepto'] != 'Dev. Capital' && $movimiento['concepto'] != 'Pago Dividendo' && $movimiento['concepto'] != 'Dev. Reajuste Capital') {  //valores cartola
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

                                        <?php 
                                          
                                          
                                          
                                         

                                          

                                         

                                          $roe = 0;

                                          $ser=null;

                                          $post_venta = $fondo['avance_proyecto'][0];

                                                        /*echo "<pre>";
                                                        var_dump($post_venta);
                                                        echo "</pre>";*/


                                                        $this->load->model('intranet/fip');
                                                        $this->load->model('intranet/Aportesfip');
                                                        $fip = (new Fip())->getById($post_venta['rel_fip_id']);
                                                        $aportesFip = (new Aportesfip())->getById($fondo['aporte_id']);
                                                        $grupo = $aportesFip->getGrupofondoaporte();
                                                        if($fip->is_multi_calls){
                                                            $call = $aportesFip->getCall();
                                                            $ser = $call->getSeries();
                                                        }else{
                                                            $ser = $fip->getSeries();
                                                        }

                                        

                                          /*$this->load->model('intranet/fip');
                                          $this->load->model('intranet/Aportesfip');
                                          $fipfond = (new Fip())->getById($post_venta['rel_fip_id']);
                                          $aportesFipfond = (new Aportesfip())->getById($fondo['aporte_id']);
                                          $grupofond = $aportesFipfond->getGrupofondoaporte();
                                          $ser = $fipfond->getSeries();*/

                                          /*echo "<pre>";
                                          var_dump($post_venta);
                                          echo "</pre>";*/

                                                        
                                          
                                          

                                                                    if ($suma_acciones >= $ser[0]->minimo && $suma_acciones <= $ser[0]->maximo) {
                                                                        $roe = $post_venta['roe_serie_a'];
                                                                   } else if (isset($ser[1]) && $suma_acciones >= $ser[1]->minimo && $suma_acciones <= $ser[1]->maximo) {
                                                                        $roe = $post_venta['roe_serie_b'];                                                                       
                                                                    } else if (isset($ser[2]) && $suma_acciones >= $ser[2]->minimo && $suma_acciones <= $ser[2]->maximo) {
                                                                        $roe = $post_venta['roe_serie_c'];
                                                                    } else {
                                                                        if(isset($ser[3])) {
                                                                            $roe = $post_venta['roe_serie_d'];
                                                                           }       
                                                                    }
                                         
                                        

                                         
                                         
                                                                                                                               
                                                       
                                                       
                                        
                                                        
                                        ?>

                                       
                                        

                                                    
                                             

                                                                             
                                        
                                        <!-- hcvSF3xZE7FspNLepU4s --> <!-- Código Bit -->

                                        <!-- <table class="table table-bordered ">
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
                                        </table> -->

                                        <?php

                                                    
                                                                 $rent = $roe/100;  
                                        
                                                                 $div_esp = $suma_acciones * $rent;
                        
                                                                 $dev_total = $suma_acciones + $suma_acciones * $rent; 
                        
                                                                 $dev_total_clp =0;
                                                               
                                                                 $capital_por_recibir = $suma_acciones - $capital_devuelto;                                                 
                                                                
                                                                                                                         
                                                                $valor_cuota = $resumen['valor_cuota'];

                                                                $saldo_contable = $resumen['saldo_contable'];

                                                                $dev_esperad_pesos = ($div_esp - $pago_dividendo) * $valor_uf_estimada + $pago_dividendo_clp + $capital_por_recibir * $valor_uf_estimada + $capital_devuelto_clp;

                                                                $div_esperad_pesos = $div_esp * $valor_uf_estimada;

                                                                $cap_por_rec_pesos = $capital_por_recibir * $valor_uf_estimada;

                                                                $div_esperad_por_rec = $div_esp - $pago_dividendo;

                                                                $div_esperad_por_rec_pesos = ($div_esp - $pago_dividendo) * $valor_uf_estimada;

                                                        
                              
                                                        
                                                                
                                                        
                                        ?>
                                                                             
                                      
                                        <div class="col-xs-12" >

                                        <?php if($fondo['moneda']=="UF"){  ?> 
                                        <div class="col-xs-12">
                                            <table class="table rounded-cartola table-bordered text-blue-aic fondo-cartola-claro">
                                                <thead class="thead-dark text-white">
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>MONTO EN UF</th>
                                                        <th>MONTO EN PESOS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Inversión Inicial</td>
                                                        <td><?= number_format($suma_acciones, 2,',','.'); ?></td>
                                                        <td><?= number_format($suma_acciones_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <?php if($roe > 0){?>
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td><?= number_format($roe, 1,',','.'); ?> %</td>
                                                        <td>--</td>
                                                    </tr>
                                                    <?php }else{?>
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                    <?php }?>
                                                        
                                                    <tr>
                                                        <td>Devolución Total Esperada</td>
                                                        <td><?= number_format($dev_total, 2,',','.'); ?></td>
                                                        <td><?= number_format($dev_esperad_pesos, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados</td>
                                                        <td><?= number_format($div_esp = ($div_esp >=0) ? $div_esp : "0" , 2,',','.'); ?></td>
                                                        <td><?= number_format($div_esperad_pesos = ($div_esperad_pesos >=0) ? $div_esperad_pesos : "0" , 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital Devuelto</td>
                                                        <td><?= number_format($capital_devuelto, 2,',','.'); ?></td>
                                                        <td><?= number_format($capital_devuelto_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital por Recibir</td>
                                                        <td><?= number_format($capital_por_recibir = ($capital_por_recibir >=0) ? $capital_por_recibir : "0" , 2,',','.'); ?></td>
                                                        <td><?= number_format($cap_por_rec_pesos = ($cap_por_rec_pesos >=0) ? $cap_por_rec_pesos : "0", 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Devueltos</td>
                                                        <td><?= number_format($pago_dividendo, 2,',','.'); ?></td>
                                                        <td><?= number_format($pago_dividendo_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados por Recibir</td>
                                                        <td><?= number_format($div_esperad_por_rec = ($div_esperad_por_rec >=0) ? $div_esperad_por_rec : "0" , 2,',','.'); ?></td>
                                                        <td><?= number_format($div_esperad_por_rec_pesos = ($div_esperad_por_rec_pesos >=0) ? $div_esperad_por_rec_pesos : "0" , 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Valor Cuota</td>
                                                        <td>--</td>
                                                        <td><?= number_format($valor_cuota, 2,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Saldo Contable</td>
                                                        <td>--</td>
                                                        <td><?= number_format($saldo_contable, 0,',','.'); ?></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>

                                            <div class="col-xs-12 izq">
                                                <figure class="highcharts-figure">
                                                    <div class="letra" id="container<?= $cont_graphic; ?>"></div>                                                                                                       
                                                </figure>
                                             </div>
                                        
                                        <?php } else if(($fondo['moneda']=="USD")||($fondo['moneda']=="EUR")){  ?> 

                                        <div class="col-xs-12">
                                            <table class="table rounded-cartola table-bordered fondo-cartola-claro text-blue-aic">
                                                <thead class="thead-dark text-white">
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>MONTO EN <?=$fondo['moneda']?></th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Inversión Inicial</td>
                                                        <td><?= number_format($suma_acciones, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    
                                                    <?php if($roe > 0){?>
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td><?= number_format($roe, 1,',','.'); ?> %</td>
                                                        
                                                    </tr>
                                                    <?php }else{?>
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td>--</td>
                                                        
                                                    </tr>
                                                    <?php }?>
                                                    
                                                      
                                                    <tr>
                                                        <td>Devolución Total Esperada</td>
                                                        <td><?= number_format($dev_total, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados</td>
                                                        <td><?= number_format($div_esp, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital Devuelto</td>
                                                        <td><?= number_format($capital_devuelto, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital por Recibir Esperados</td>
                                                        <td><?= number_format($capital_por_recibir = ($capital_por_recibir >=0)? $capital_por_recibir : "0", 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Devueltos</td>
                                                        <td><?= number_format($pago_dividendo, 2,',','.'); ?></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados por Recibir</td>
                                                        <td><?= number_format($div_esp - $pago_dividendo, 2,',','.'); ?></td>
                                                       
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Valor Cuota</td>
                                                        <td><?= number_format($resumen['valor_cuota'], 2,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Saldo Contable</td>
                                                        <td><?= number_format($resumen['saldo_contable'], 0,',','.'); ?></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>

                                            <div class="col-xs-12 izq">
                                                <figure class="highcharts-figure">
                                                    <div id="container<?= $cont_graphic; ?>"></div>                                                                                                       
                                                </figure>
                                             </div>
                                        
                                             <?php } else { ?>

                                                <div class="col-xs-12">
                                            <table class="table rounded-cartola table-bordered fondo-cartola-claro text-blue-aic">
                                                <thead class="thead-dark text-white">
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>MONTO EN PESOS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Inversión Inicial</td>
                                                        <td><?= number_format($suma_acciones_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                                                                      
                                                    <?php if($roe > 0){?>
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td><?= number_format($roe, 1,',','.'); ?> %</td>
                                                        
                                                    </tr>
                                                    <?php }else{?>
                                                    <tr>
                                                        <td>ROE Esperado</td>
                                                        <td>--</td>
                                                        
                                                    </tr>
                                                    <?php }?>
                                                    
                                                       
                                                    <tr>
                                                        <td>Devolución Total Esperada</td>
                                                        <td><?= number_format($suma_acciones_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados</td>
                                                        <td><?= number_format($suma_acciones_clp * $rent, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital Devuelto</td>
                                                        <td><?= number_format($capital_devuelto_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Capital por Recibir Esperados</td>
                                                        <td><?= number_format($suma_acciones_clp - $capital_devuelto_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Devueltos</td>
                                                        <td><?= number_format($pago_dividendo_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dividendos Esperados por Recibir</td>
                                                        <td><?= number_format($suma_acciones_clp*$rent - $pago_dividendo_clp, 0,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td >Valor Cuota</td>
                                                        
                                                        <td><?= number_format($resumen['valor_cuota'], 2,',','.'); ?></td>
                                                    </tr>
                                                    <tr class="tr-fondo-capital">
                                                        <td>Saldo Contable</td>
                                                        
                                                        <td><?= number_format($resumen['saldo_contable'], 0,',','.'); ?></td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>

                                            <div class="col-xs-12 izq">
                                                <figure class="highcharts-figure">
                                                    <div id="container<?= $cont_graphic; ?>"></div>                                                                                                       
                                                </figure>
                                             </div>

                                             <?php } ?>

                                            
                                        </div>
                                        

                                       



                                         <script>
                                                          
                                            

                                                        Highcharts.chart('container<?= $cont_graphic; ?>', {

                                                            
                                                            
                                                        title: {
                                                        text: 'RETORNO ESPERADO',
                                                        align: 'left'
                                                        },

                                                        
                                                        yAxis: {
                                                            title: {
                                                            text: '',
                                                            min: 0,
                                                            max: <?= $roe;?>,
                                                            style: {
                                                                fontSize: '14px', // Aquí especificas el tamaño de letra deseado.
                                                            },
                                                            },
                                                            labels: {
                                                                format: '{value}%',
                                                            style: {
                                                                fontSize: '14px', // Aquí especificas el tamaño de letra deseado para las categorías.
                                                            },
                                                            },
                                                        },

                                                      

                                                         xAxis: {
                                                                    type: 'datetime',
                                                                    tickInterval: 365 * 24 * 3600 * 1000, // Intervalo de 1 día en milisegundos
                                                                    min: new Date('<?=$post_venta['fecha_inicio'];?>').getTime(),
                                                                    max: new Date('<?=$post_venta['fecha_real_proyectada_cierre'];?>').getTime(),
                                                                    labels: {
                                                                    style: {
                                                                        fontSize: '14px', // Aquí especificas el tamaño de letra deseado para las categorías.
                                                                    },
                                                                    },
                                                                    dateTimeLabelFormats: {
                                                                    day: '%e %b', // Formato para días: "15 Jul"
                                                                    week: '%e %b', // Formato para semanas: "15 Jul"
                                                                    month: '%b \'%y', // Formato para meses: "Jul '23"
                                                                    year: '%Y' // Formato para años: "2023"
                                                                    }, 
                                                                    
                                                                },

                                                        legend: {
                                                           
                                                            enabled: false
                                                        },

                                                        exporting: {
                                                            enabled: false, // Deshabilitar el menú con las opciones de exportación.
                                                        },

                                                        plotOptions: {
                                                            series: {
                                                            dataLabels: {
                                                                enabled: false, // Deshabilitar las etiquetas de los puntos de datos en todas las series.
                                                            }
                                                            }
                                                        },

                                                        series: [{
                                                        name: '',
                                                        data: [[new Date('<?=$post_venta['fecha_inicio'];?>').getTime(),0],
                                                                [new Date('<?=$post_venta['fecha_real_proyectada_cierre'];?>').getTime(),<?= $roe;?>]
                                                                ],
                                                        dashStyle: 'Dash',
                                                        lineWidth: 3,
                                                        dataLabels: {
                                                        format: '{y}%',
                                                        enabled: true, // Habilitar las etiquetas de los puntos de datos.
                                                        align: 'right', // Alinear las etiquetas a la derecha del punto de datos.
                                                        showInLegend: false, // Ocultar la serie en la leyenda.
                                                        x: -10, // Desplazar las etiquetas 10 píxeles hacia la izquierda para que estén al final de la línea.
                                                        style: {
                                                            fontSize: '14px', // Tamaño de letra deseado para el texto de la serie.
                                                        },
                                                        },
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
                                                        },
                                                        options: {
        scales: {
            yAxes: [{
            ticks: {
                   min: 0,
                   max: 100,
                   callback: function(value){return value+ "%"}
                },
                        scaleLabel: {
                   display: true,
                   labelString: "Percentage"
                }
            }]
        }
    }
                                                      
                                                        });

                                            </script>
                                          
                                                    <?php 
                                                      $cont_graphic++;
                                                      $roe =0;
                                                      $most_rent =0; 
                                                      
                                                      ?>

                                                      



                                        <? if(count($fondo['avance_proyecto']) > 0) {

                                            $avance_proyecto = $fondo['avance_proyecto'][0];

                                            if ($avance_proyecto['mostrar_grafico_cartola'] == 1) {
                                                ?>
                                                <table class="table table-condensed">
                                                    <tr>
                                                        <td colspan="6"><h5><u>Indicadores del Proyecto</u></h5></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h5>1.- Avance del Proyecto</h5>
                                                        </td>
                                                        <td colspan="1">
                                                            <h5 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h5>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="semaforo vcenter">
                                                                <?
                                                                if ($avance_proyecto['atraso_meses'] <= 3) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/green-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                                <?php
                                                                if ($avance_proyecto['atraso_meses'] > 3 && $avance_proyecto['mostrar_rojo'] == 0) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/yellow-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                                <?php
                                                                if ($avance_proyecto['atraso_meses'] > 3 && $avance_proyecto['mostrar_rojo'] == 1) {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/red-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img src="<?= base_url('assets/img/grey-dot.png') ?>"
                                                                         width="9" height="9" class="responsive"/>
                                                                    <?php
                                                                } ?>
                                                            </div>
                                                        </td>
                                                        <td colspan="1">
                                                            <table class="">
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/green-dot.png') ?>"
                                                                             width="9" height="9"/></td>
                                                                    <td>Proyecto avanzando de acuerdo a lo estimado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/yellow-dot.png') ?>"
                                                                             width="9" height="9"/></td>
                                                                    <td>Proyecto avanzando más lento a lo estimado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="<?= base_url('assets/img/red-dot.png') ?>"
                                                                             width="9" height="9"/></td>
                                                                    <td>Proyecto con problemas en su desarrollo</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h5>2.- Progreso Estimado</h5>
                                                        </td>
                                                        <td colspan="1">
                                                            <h5 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h5>
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
                                                            <td colspan="6"><h5><u>Indicadores del Proyecto</u></h5></td>
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
                                                            <h5 class="vcenter">
                                                                <span class="glyphicon glyphicon-arrow-right"
                                                                      aria-hidden="true"></span>
                                                            </h5>
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
                                                                                    $rentabilidad = 0;

                                                                                } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $aux_avance_proyecto['roe_serie_b'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_b'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[1]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
                                                                                } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                                    /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $aux_avance_proyecto['roe_serie_c'];*/
                                                                                    $rentabilidad = $aux_avance_proyecto[0]['roe_serie_c'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[2]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
                                                                                } else {
                                                                                    if(isset($series[3])) {
                                                                                        /*$rentabilidad = (empty($aux_avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $aux_avance_proyecto['roe_serie_d'];*/
                                                                                        $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                            echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                        }else {
                                                                                               echo '' . $series[3]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                              }
                                                                                              $rentabilidad = 0;
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
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else {
                                                                        if(isset($series[3])) {
                                                                            /*$rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];*/
                                                                            $rentabilidad = $aux_avance_proyecto[0]['roe_serie_d'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';

                                                                            }
                                                                            $rentabilidad = 0;
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
                                                                                    $rentabilidad = 0;
                                                                                } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $aux_avance_proyecto['roe_serie_b'];


                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_b'];
                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[1]->serie . ' &nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
                                                                                } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                                    $rentabilidad = (empty($aux_avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $aux_avance_proyecto['roe_serie_c'];
                                                                                     $rentabilidad = $aux_avance_proyecto[0]['roe_serie_c'];


                                                                                    if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                        echo '' . $series[0]->serie . '  '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }else {
                                                                                        echo '' . $series[2]->serie . '&nbsp;&nbsp;  UF + ' . number_format($rentabilidad,1,',','.') . '%';
                                                                                    }
                                                                                    $rentabilidad = 0;
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
                                                                                    $rentabilidad = 0;
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
                                                                            $rentabilidad = 0;
                                                                        } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                            $rentabilidad = 0;
                                                                        } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }
                                                                            $rentabilidad = 0;
                                                                        } else {
                                                                            if(isset($series[3])) {
                                                                                $rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];


                                                                                if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                    echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                                }else {
                                                                                    echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';

                                                                                }
                                                                            }
                                                                            $rentabilidad = 0;
                                                                            
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
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[1]) && $monto_uf_aporte >= $series[1]->minimo && $monto_uf_aporte <= $series[1]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_b'])) ? $series[1]->rentabilidad : $avance_proyecto['roe_serie_b'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[1]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else if (isset($series[2]) && $monto_uf_aporte >= $series[2]->minimo && $monto_uf_aporte <= $series[2]->maximo) {
                                                                        $rentabilidad = (empty($avance_proyecto['roe_serie_c'])) ? $series[2]->rentabilidad : $avance_proyecto['roe_serie_c'];


                                                                        if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                            echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }else {
                                                                            echo '<h3 > ' . $series[2]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    } else {
                                                                        if(isset($series[3])) {
                                                                            $rentabilidad = (empty($avance_proyecto['roe_serie_d'])) ? $series[3]->rentabilidad : $avance_proyecto['roe_serie_d'];


                                                                            if(($fip->getMoneda()->moneda == 'USD')||($fip->getMoneda()->moneda == 'EUR')){
                                                                                echo '<h3 > ' . $series[0]->serie . ' '.$fip->getMoneda()->moneda.' + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                            }else {
                                                                                echo '<h3 > ' . $series[3]->serie . '&nbsp;&nbsp; UF + ' . number_format($rentabilidad,1,',','.') . '%</h3>';
                                                                                  }
                                                                        }
                                                                        $rentabilidad = 0;
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </td>
                                                    </tr> <!-- Prueba Datos -->
                                                    <tr>

                                                    <div class="col-xs-12">
                                                            <?php //echo "<pre>"; var_dump($avance_proyecto); echo "</pre>"; 

                                                                $most_rent = $rentabilidad;  
                                                                                                                               
                                                                $rentabilidad = $most_rent/100; //rentabilidad del fondo
                                                                
                                                                $inversion_inicial_uf = $suma_acciones; //suma de aportes 
                                                               
                                                                $inversion_inicial_clp = $suma_acciones_clp;
                                                                
                                                                $saldo_capital_entregado_uf = $capital_devuelto;
                                                                
                                                                $saldo_capital_entregado_clp = $capital_devuelto_clp;
                                                                
                                                                $dividendos_esperados_uf = $inversion_inicial_uf * $rentabilidad;

                                                                $dividendos_esperados_clp = $pago_dividendo_clp + $dividendos_esperados_uf * $valor_uf_estimada;
                                                                
                                                                $monto_capital_por_recibir_uf = $inversion_inicial_uf - $saldo_capital_entregado_uf;

                                                                $monto_dividendos_por_recibir_clp = $dividendos_esperados_uf * $valor_uf_estimada;
                                                                
                                                                $monto_capital_por_recibir_clp = $monto_capital_por_recibir_uf * $valor_uf_estimada;

                                                                $dividendos_total_clp = $pago_dividendo_clp + $monto_dividendos_por_recibir_clp;
                                                                
                                                                $saldo_dividendos_entregados_clp = $pago_dividendo_clp;
                                                                                                         
                                                                $saldo_dividendos_entregados_uf = $pago_dividendo;
                                                                                                                          
                                                                $monto_dividendos_por_recibir_uf = $dividendos_esperados_uf - $saldo_dividendos_entregados_uf;
                                                                                                                     
                                                                $devolucion_total_uf_esp = $inversion_inicial_uf + ($inversion_inicial_uf*$rentabilidad); //estimacion de la devolución

                                                                                                                                
                                                                $devolucion_total_clp_esp = 0; //suma de capitales y dividendos

                                                                if($capital_devuelto_clp > $inversion_inicial_clp){
                                                                    $devolucion_total_clp_esp = $capital_devuelto_clp + $dividendos_total_clp;
                                                                }else{
                                                                    $devolucion_total_clp_esp = $saldo_capital_entregado_clp + $monto_capital_por_recibir_clp + $dividendos_total_clp;
                                                                }
                                                                
                                                           
                                                                $valor_cuota = $resumen['valor_cuota'];

                                                                $saldo_contable = $resumen['saldo_contable'];
                                                                
                                                            ?>
                                                                       <!-- hcvSF3xZE7FspNLepU4s --> <!-- Código Bit  -->
                                                                        
                                                                            
                                                                            

                                                                                                                                                                      
                                                                
                                                               
                                                            </div>

                                                    </tr>


                                            
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
                                    <div class="alert alert-grey">
                                        <strong>Nota:</strong>
                                        <ol>
                                            <li><p align="justify">Estimado Inversionista, para su información y mejor comprensión de la cartola, queremos indicarle que el valor cuota o acción a la fecha de esta cartola es referencial, y está basado en el valor contable del patrimonio del Fondo o Sociedad, donde la inversión en el proyecto está reflejada a su valor histórico y no en base al Valor Económico del Proyecto.</p></li>
                                            <?php if($fondo['moneda']== 'UF'){ ?>
                                            <li><p align="justify">Todas las estimaciones de devolución de capital y dividendos esperados son calculadas en pesos en función de las estimaciones de inflación futura que hace el Banco Central de Chile en su IPOM y son ajustados trimestralmente.</p></li>
                                            <?php }?>
                                            <?if(isset($series) && count($series) > 0 && $avance_proyecto['mostrar_roe']== 1):?>
                                            <li><p>El indicador de Retorno Estimado es una proyección efectuada con la información proporcionada por la Inmobiliaria Gestora del proyecto y algunos supuestos propios.</p></li>
                                            <? endif; ?>
                                            <?if(isset($fondo['comentario'])):?>
                                            <li><p align="justify"><?=$fondo['comentario'];?></p></li>
                                            <?endif;?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <br>
                        
                    <?php
                }
                
                //echo '<p style="page-break-after: always;"></p>'; 
                
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
        
        <?php echo '<p style="page-break-before: always;"></p>'; ?>
        
        <div class= "row text-blue-aic fondo-encabezado rounded-cartola px-3" style="margin-bottom: 100px;padding-bottom: 30px;margin-top: 25px;">
            <div class="col-xs-12">
                <h3 class="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">RESUMEN</h3>
            </div>
                       
            <?php if (count($fondos) > 2) { ?>
            <div class="col-xs-12">
                <div class="">
              
                    <?foreach($resumenes_saldos as $k => $resumenes_saldo):?>
                        <? if($k == 'USD'): ?>
                        <div class="row">
                            <div class="col-xs-12">
                                
                                 <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN DÓLARES</h4>

                               

<table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title margen-texto">

    <thead class="thead-dark text-white">
        <tr>
            <th class="col-md-6"></th>
            <th class="col-md-2 text-center">Saldo Contable</th>
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
            <?php

                /*echo "<pre>";
                var_dump($resumen);
                echo "</pre>";*/
               
        }
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
                                
                                 <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN EUROS</h4>

<table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title">

    <thead class="thead-dark text-white">
        <tr>
            <th class="col-md-6"></th>
            <th class="col-md-2 text-center">Saldo Contable</th>
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

<? elseif($k == 'CLP'): ?>
    <div class="row">
                            <div class="col-xs-12">
                                
                                 <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN CLP</h4>

<table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title">

    <thead class="thead-dark text-white">
        <tr>
            <th class="col-md-6"></th>
            <th class="col-md-2 text-center">Saldo Contable</th>
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

                                <h4 class ="fondo-cartola rounded-cartola text-blue-aic p-h3 d-inline-block">FONDOS EN UF</h4>
                                <table class="table table-bordered fondo-cartola-claro  rounded-cartola p-h3 panel-title">
                                    <thead class="thead-dark text-white">
                                    <tr>
                                        <th class="col-md-6"></th>
                                        <th class="col-md-2 text-center">Saldo Contable</th>
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
<style type="text/css">
    .row {
    margin-right: 0px!important;
    margin-left: 0px!important;
    margin-top: 2px!important;
}


</style>

</body>

</html>
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
<style type="text/css">
    .row {
    margin-right: 0px!important;
    margin-left: 0px!important;
    margin-top: 2px!important;
}


</style>

</body>

</html>