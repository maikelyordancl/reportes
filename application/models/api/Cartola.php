<?php
/**
 * Created by PhpStorm.
 * User: wafle
 * Date: 25-01-18
 * Time: 11:33
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartola extends CI_Model
{

    private $intranet;

    public function __construct()
    {
        parent::__construct();
        $this->intranet = $this->load->database('intranet_aicapitals', true);
    }

    public function get_cliente_by_key_encriptada($key_encriptada)
    {
        $query = "select * from trabajo__cliente where key_encriptada = '".$key_encriptada."'";
        return $this->intranet->query($query)->result_array();
    }
    
    public function get_aportes($id_cliente, $month = NULL, $year = NULL)
    {
        $query = "select ROW_NUMBER() OVER () id,* from (
			select apo.rel_cliente_id,apo.rel_aporte_fip_id
			,case 
			when fip.rel_categoria_id = 6 then ((apo.aportado_clp*fip.pagare)/100)::integer
			else apo.aportado_clp::integer 
			end as monto_clp
			,case 
			when apo.rel_aporte_fip_id = 6 then (apo.aportado_clp / 1000)::integer
			when fip.rel_categoria_id = 6 then ((apo.aportado_uf*fip.pagare)/100)::integer
			else apo.aportado_uf::integer
			end as monto_uf
			,case
			when apo.rel_aporte_fip_id = 6 then 1000
			else
			    case 
			        WHEN (tm.moneda = 'USD' OR tm.moneda = 'EUR') THEN
			            tp.valor_cuota
			        ELSE
			            m.valor
			        END 			    
			end as valor_uf
			,'Aporte' as Concepto,apo.fecha
			,apo.saldo_cuotas::integer saldo_cuotas
			,tm.moneda
			from trabajo__aportes_FIP apo
			inner join vw_pagos pag on pag.rel_aporte_fip_id = apo.id
			inner join trabajo__Monedas_Valor m on apo.fecha_uf = m.fecha
			inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
			inner join trabajo__monedas tm on tm.id = fip.moneda_id
			inner join trabajo__patrimonio tp on tp.rel_fip_id = fip.id
			where apo.estado_pago IN ('1', '4')
			and pag.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			and tp.fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			and rel_cliente_id = ".$id_cliente."
			union all

			select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp*-1 monto_clp
			,dev.monto_uf*-1 monto_uf
			,pat.valor_cuota valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
			,dev.saldo_cuotas saldo_cuotas
			,tm.moneda
			from trabajo__Devolucion dev
			inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
			inner join trabajo__Monedas_Valor m on dev.fecha_uf = m.fecha
			inner join trabajo__Monedas_Valor m_apo on apo.fecha_uf = m_apo.fecha
			inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
			inner join trabajo__Patrimonio pat on date(date_trunc('month',pat.fecha)+'2month'::interval-'1day'::interval) = date(date_trunc('month',dev.fecha_pago)+'1month'::interval-'1day'::interval) and pat.rel_fip_id = apo.rel_aporte_fip_id
			inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
			inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where rel_cliente_id = ".$id_cliente."
			and dev.rel_tipo_devolucion_id = 1
			and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			
			union all

			select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp*-1 monto_clp
			,dev.monto_uf*-1 monto_uf
			,pat.valor_cuota valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
			,dev.saldo_cuotas saldo_cuotas
			,tm.moneda
			from trabajo__Devolucion dev
			inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
			inner join trabajo__Monedas_Valor m on dev.fecha_uf = m.fecha
			inner join trabajo__Monedas_Valor m_apo on apo.fecha_uf = m_apo.fecha
			inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
			inner join trabajo__Patrimonio pat on date(date_trunc('month',pat.fecha)+'2month'::interval-'1day'::interval) = date(date_trunc('month',dev.fecha_pago)+'1month'::interval-'1day'::interval) and pat.rel_fip_id = apo.rel_aporte_fip_id
			inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
			inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where rel_cliente_id = ".$id_cliente."
			and dev.rel_tipo_devolucion_id = 2
			and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date

			union all

			select apo.rel_cliente_id,apo.rel_aporte_fip_id,((apo.aportado_clp*(100-fip.pagare))/100)::integer monto_clp
			,((apo.aportado_uf*(100-fip.pagare))/100)::integer monto_uf
			,m.valor valor_uf
			,'Pagaré' concepto,apo.fecha
			,apo.saldo_pagare::integer saldo_cuotas
			,tm.moneda
			from trabajo__aportes_FIP apo
			inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
			inner join trabajo__Monedas_Valor m on apo.fecha_uf = m.fecha
			inner join vw_pagos pag on pag.rel_aporte_fip_id = apo.id
			inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where rel_cliente_id = ".$id_cliente."
			and pag.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			and fip.rel_categoria_id = 6

			union all

			select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp*-1 monto_clp
			,dev.monto_uf*-1  monto_uf
			,0 valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
			,0 saldo_cuotas
			,tm.moneda
			from trabajo__Devolucion dev
			inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
			inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
			inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
            inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where rel_cliente_id = ".$id_cliente."
			and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			and dev.rel_tipo_devolucion_id = 4

			union all

			select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp*-1 monto_clp
			,0 monto_uf
			,0 valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
			,0 saldo_cuotas
			,tm.moneda
			from trabajo__Devolucion dev
			inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
			inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
            inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
            inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where rel_cliente_id = ".$id_cliente."
			and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			and dev.rel_tipo_devolucion_id IN (5,7)

			union all

			select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp*-1 monto_clp
			,dev.monto_uf monto_uf
			,dev.saldo_cuotas valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
			,0 saldo_cuotas
			,tm.moneda
			from trabajo__Devolucion dev
			inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
			inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
            inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
            inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where rel_cliente_id = ".$id_cliente."
			and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			and dev.rel_tipo_devolucion_id IN (6)			
			
		)a
		order by rel_aporte_fip_id,fecha,a.concepto";

        return $this->intranet->query($query)->result_array();
    }

    public function get_fondos($id_cliente, $month = NULL, $year = NULL)
    {
        $query = "select ROW_NUMBER() OVER () id,a.* 
		from(		    
			select distinct apo.rel_aporte_fip_id
			,apo.id as aporte_id
			,fip.nombre_largo
			,fip.moneda_id
			,tm.moneda
			,fip.inicio
			,fip.id id_fondo
			,cat.id id_categoria
			,cat.categoria
			,'".$this->get_cierre_mes($month, $year)['end_date']."'::date periodo
			from trabajo__aportes_FIP apo
			inner join trabajo__FIP fip on apo.rel_aporte_fip_id = fip.id
			inner join trabajo__Categoria cat on cat.id = fip.rel_categoria_id
			inner join vw_pagos pag on pag.rel_aporte_fip_id = apo.id
			inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where apo.estado_pago IN ('1', '4')
			and apo.rel_cliente_id = ".$id_cliente."
			and pag.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
			AND apo.fecha_liquidar IS NOT NULL
            AND '".$this->get_cierre_mes($month, $year)['end_date']."'::date - interval '2 days' <= apo.fecha_liquidar                      
            UNION
            select distinct apo.rel_aporte_fip_id
            ,apo.id as aporte_id
			,fip.nombre_largo
			,fip.moneda_id
			,tm.moneda
			,fip.inicio
			,fip.id id_fondo
			,cat.id id_categoria
			,cat.categoria
			,'".$this->get_cierre_mes($month, $year)['end_date']."'::date periodo
			from trabajo__aportes_FIP apo
			inner join trabajo__FIP fip on apo.rel_aporte_fip_id = fip.id
			inner join trabajo__Categoria cat on cat.id = fip.rel_categoria_id
			inner join vw_pagos pag on pag.rel_aporte_fip_id = apo.id
			inner join trabajo__monedas tm on tm.id = fip.moneda_id
			where apo.estado_pago IN ('1', '4')
			and apo.rel_cliente_id = ".$id_cliente."
			and pag.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
            AND apo.fecha_liquidar IS NULL
		)a order by a.id_fondo;";

        return $this->intranet->query($query)->result_array();

    }

    /**
     * GET RESUMEN PERIODO DE LA CARTOLA
     * @param $id_cliente
     * @param null $month
     * @param null $year
     * @return mixed
     */
    public function get_resumen($id_cliente, $month = NULL , $year = NULL)
    {
        $query = "select ROW_NUMBER() OVER () id, a.* from(
                      select
                       rel_aporte_fip_id
                      ,nombre_largo
                      ,valor_cuota
                      ,periodo
                      ,concepto
                      ,
                      CASE
                        WHEN a.rel_aporte_fip_id = 24 and concepto = 'Pagaré' THEN
                          calcular_pagare_bono_hipotecario_2(a.rel_aporte_fip_id, a.rel_cliente_id, '".$this->get_cierre_mes($month, $year)['end_date']."'::date)
                        ELSE
                        sum(saldo_contable)
                      END saldo_contable
                      ,sum(cuotas_vigentes)cuotas_vigentes
                       from (
                            select ROW_NUMBER() OVER () id,a.*
                                  ,b.capital_pagado_uf
                                  ,fip.nombre_largo
                                  ,round(pat.valor_cuota::numeric,2) valor_cuota
                                  ,'".$this->get_cierre_mes($month, $year)['end_date']."'::date periodo
                                  ,case 
                                  when a.rel_aporte_fip_id = 6 then round(((a.monto_clp/1000) * pat.valor_cuota)::numeric,2)
                                  when fip.rel_categoria_id = 6 and a.concepto = 'Aporte' then round((a.monto_uf * pat.valor_cuota)::numeric,2)
                                  when a.rel_aporte_fip_id = 24 and fip.rel_categoria_id = 6 and a.concepto = 'Pagaré' then (((a.saldo_cuotas - coalesce(c.dev_cap_pag,0)) * mon_per.valor)+((a.saldo_cuotas - coalesce(c.dev_cap_pag,0)) * mon_per.valor)*0.00407412378364835)
                                  when a.rel_aporte_fip_id = 25 or fip.rel_categoria_id = 6 and a.concepto = 'Pagaré' then
                                    ((a.monto_uf*(select valor from trabajo__monedas_valor WHERE rel_moneda_id = 1 and fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date ) * 0.05)/365*
                                     (select abs((SELECT (date_trunc('month', now()) + interval '0 month' - interval '1 day')::date) - a.fecha::date)))+
                                    (a.monto_uf*(select valor from trabajo__monedas_valor WHERE rel_moneda_id = 1 and fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date ))
                                  else
                                    CASE
                                      WHEN (a.monto_uf-coalesce(capital_pagado_uf,0)) = 0 THEN
                                        round((1 * pat.valor_cuota)::NUMERIC,2)
                                      ELSE
                                        round(((a.monto_uf-coalesce(capital_pagado_uf,0)) * pat.valor_cuota)::NUMERIC,2)
                                    END 
                                  end as saldo_contable
                                  ,case
                                  when a.rel_aporte_fip_id = 6 then (monto_clp-coalesce(capital_pagado_uf,0))/1000::integer
                                  else monto_uf-coalesce(capital_pagado_uf,0)
                                  end as cuotas_vigentes
                
                                   from (
                                        select apo.rel_cliente_id,apo.rel_aporte_fip_id
                                        ,case 
                                        when fip.rel_categoria_id = 6 then ((apo.aportado_clp*fip.pagare)/100)::integer
                                        else apo.aportado_clp::integer 
                                        end as monto_clp
                                        ,case 
                                        when apo.rel_aporte_fip_id = 6 then (apo.aportado_clp / 1000)::integer
                                        when fip.rel_categoria_id = 6 then ((apo.aportado_uf*fip.pagare)/100)::integer
                                        else apo.aportado_uf::integer
                                        end as monto_uf
                                        ,case
                                        when apo.rel_aporte_fip_id = 6 then 1000
                                        else m.valor
                                        end as valor_uf
                                        ,'Aporte' as Concepto,apo.fecha
                                        ,apo.saldo_cuotas::integer saldo_cuotas
                                        from trabajo__aportes_FIP apo
                                        inner join vw_pagos pag on pag.rel_aporte_fip_id = apo.id
                                        inner join trabajo__Monedas_Valor m on apo.fecha_uf = m.fecha
                                        inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
                                        where
                                            CASE
                                            WHEN apo.fecha_liquidar IS NOT NULL THEN
                                              (apo.fecha_liquidar  >= date '".$this->get_cierre_mes($month, $year)['end_date']."'::date - interval '2 days' OR
                                                apo.fecha_liquidar >= date '".$this->get_cierre_mes($month, $year)['end_date']."'::date + interval '2 days')
                                            ELSE
                                                apo.estado_pago = '1'
                            
                                        END
                                        and pag.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                                        and rel_cliente_id = ".$id_cliente."
                
                                        union all
                
                                        select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp*-1 monto_clp
                                        ,dev.monto_uf*-1 monto_uf
                                        ,pat.valor_cuota valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
                                        , dev.saldo_cuotas saldo_cuotas
                                        from trabajo__Devolucion dev
                                        inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                                        inner join trabajo__Monedas_Valor m on dev.fecha_uf = m.fecha
                                        inner join trabajo__Monedas_Valor m_apo on apo.fecha_uf = m_apo.fecha
                                        inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                                        inner join trabajo__Patrimonio pat on date(date_trunc('month',pat.fecha)+'2month'::interval-'1day'::interval) = date(date_trunc('month',dev.fecha_pago)+'1month'::interval-'1day'::interval) and pat.rel_fip_id = apo.rel_aporte_fip_id
                                        where rel_cliente_id = ".$id_cliente."
                                        and dev.rel_tipo_devolucion_id = 1
                                        and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                                        
                                        union all
                
                                        select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp
                                        ,0 monto_uf
                                        ,0 valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
                                        ,0 saldo_cuotas
                                        from trabajo__Devolucion dev
                                        inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                                        inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                                        
                                        where rel_cliente_id = ".$id_cliente."
                                        and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                                        and dev.rel_tipo_devolucion_id = 2
                
                                        union all
                
                                        select apo.rel_cliente_id,apo.rel_aporte_fip_id,((apo.aportado_clp*(100-fip.pagare))/100)::integer monto_clp
                                        ,((apo.aportado_uf*(100-fip.pagare))/100)::integer monto_uf
                                        ,m.valor valor_uf
                                        ,'Pagaré' concepto,apo.fecha
                                        ,case
                                        when apo.rel_aporte_fip_id = 24 then apo.aportado_uf * 0.98
                                        when apo.rel_aporte_fip_id = 25 then apo.valor_contable
                                        end as saldo_cuotas
                                        from trabajo__aportes_FIP apo
                                        inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
                                        inner join trabajo__Monedas_Valor m on apo.fecha_uf = m.fecha
                                        where rel_cliente_id = ".$id_cliente."
                                        and apo.estado_pago = '1'
                                        and fip.rel_categoria_id = 6
                
                                        
                                  )a
                
                                  full join(
                                    select apo.rel_aporte_fip_id
                                    ,case
                                    when apo.rel_aporte_fip_id = 6 then (sum(dev.monto_clp))/1000
                                    else 
                                        CASE
                                          WHEN tip.tipo_devolucion = 'Pago Final' THEN
                                            sum(dev.monto_uf)
                                          ELSE
                                            0
                                        END
                                    end as capital_pagado_uf
                                    ,sum(dev.monto_clp)capital_pagado_clp
                                    from trabajo__Devolucion dev
                                    inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                                    inner join trabajo__tipo_devolucion tip on dev.rel_tipo_devolucion_id = tip.id
                                    full join trabajo__Patrimonio pat on date(date_trunc('month',pat.fecha)+'2month'::interval-'1day'::interval) = date(date_trunc('month',dev.fecha_pago)+'1month'::interval-'1day'::interval)  and pat.rel_fip_id = apo.rel_aporte_fip_id
                                    where rel_tipo_devolucion_id = 1
                                    and apo.rel_cliente_id = ".$id_cliente."
                                    and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                                    group by 1,tip.tipo_devolucion
                                  )b on a.rel_aporte_fip_id = b.rel_aporte_fip_id
                                  
                                  full join(
                                        select apo.rel_aporte_fip_id,sum(dev.monto_uf)dev_cap_pag
                                        from trabajo__Devolucion dev
                                        inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                                        inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                
                                        where rel_cliente_id = ".$id_cliente."
                                        and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                                        and dev.rel_tipo_devolucion_id = 4
                                        group by 1
                                  )c on a.rel_aporte_fip_id = c.rel_aporte_fip_id
                
                            full join(
                              select apo.rel_aporte_fip_id,sum(dev.monto_clp)dev_int_pag
                              from trabajo__Devolucion dev
                              inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                              inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                
                              where rel_cliente_id = ".$id_cliente."
                              and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                              and dev.rel_tipo_devolucion_id = 5
                              group by 1
                            )d on a.rel_aporte_fip_id = c.rel_aporte_fip_id
                
                            full join trabajo__Monedas_Valor mon_per on mon_per.fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                
                
                                  full join (
                                    select *
                                    from trabajo__Patrimonio pat
                                    where date(date_trunc('month',pat.fecha)+'1month'::interval-'1day'::interval) = '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                                  )pat on pat.rel_fip_id = a.rel_aporte_fip_id
                                  inner join trabajo__FIP fip on fip.id = a.rel_aporte_fip_id
                                  where a.rel_cliente_id = ".$id_cliente."
                                  and a.concepto in ('Aporte','Pagaré')
                                  order by fip.id,rel_aporte_fip_id,a.fecha,a.concepto asc
                            )a
                      group by 1,2,3,4,5,a.rel_cliente_id
                      )a
                      order by rel_aporte_fip_id,concepto
                    ;";
        return $this->intranet->query($query)->result_array();
    }

    public function get_resumen_saldos($id_cliente, $month = NULL , $year = NULL)
    {
        $query = "select
                    a.rel_aporte_fip_id id
                    ,a.nombre_largo
                    ,CASE
                        WHEN a.rel_aporte_fip_id = 24 THEN
                          calcular_pagare_bono_hipotecario_2(a.rel_aporte_fip_id, a.rel_cliente_id, ('".$this->get_cierre_mes($month, $year)['end_date']."'::date) ,  TRUE)::int+calcular_pagare_bono_hipotecario_2(a.rel_aporte_fip_id, a.rel_cliente_id, ('".$this->get_cierre_mes($month, $year)['end_date']."'::date))::INT
                        ELSE
                        sum(saldo_contable)
                      END saldo_contable
                    from(
                      select ROW_NUMBER() OVER () id,a.*
                        ,b.capital_pagado_uf
                        ,fip.nombre_largo
                        ,round(pat.valor_cuota::numeric,2) valor_cuota
                        ,'".$this->get_cierre_mes($month, $year)['end_date']."'::date periodo        
                        ,case 
                          when a.rel_aporte_fip_id = 6 then round(((a.monto_clp/1000) * pat.valor_cuota)::numeric,2)
                          when fip.rel_categoria_id = 6 and a.concepto = 'Aporte' then round((a.monto_uf * pat.valor_cuota)::numeric,2)
                          when a.rel_aporte_fip_id = 24 and fip.rel_categoria_id = 6 and a.concepto = 'Pagaré' then 
                          (((a.saldo_cuotas - coalesce(c.dev_cap_pag,0)) * mon_per.valor)+((a.saldo_cuotas - coalesce(c.dev_cap_pag,0)) * mon_per.valor)*0.00407412378364835)
                          when a.rel_aporte_fip_id = 25 or fip.rel_categoria_id = 6 and a.concepto = 'Pagaré' then
                            ((a.monto_uf*(select valor from trabajo__monedas_valor WHERE rel_moneda_id = 1 and fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date) * 0.05)/365*
                             (select abs((SELECT (date_trunc('month', now()) + interval '0 month' - interval '1 day')::date) - a.fecha::date)))+
                            (a.monto_uf*(select valor from trabajo__monedas_valor WHERE rel_moneda_id = 1 and fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date ))
                          else
                            CASE
                              WHEN (a.monto_uf-coalesce(capital_pagado_uf,0)) = 0 THEN
                                round((1 * pat.valor_cuota)::NUMERIC,2)
                              ELSE
                                round(((a.monto_uf-coalesce(capital_pagado_uf,0)) * pat.valor_cuota)::NUMERIC,2)
                            END 
                          end as saldo_contable
                        ,case
                        when a.rel_aporte_fip_id = 6 then (monto_clp-coalesce(capital_pagado_uf,0))/1000::integer
                        else monto_uf-coalesce(capital_pagado_uf,0)
                        end as cuotas_vigentes                
                        from (                                   
                          select apo.rel_cliente_id,apo.rel_aporte_fip_id
                          ,case 
                          when fip.rel_categoria_id = 6 then ((apo.aportado_clp*fip.pagare)/100)::integer
                          else apo.aportado_clp::integer 
                          end as monto_clp
                          ,case 
                          when apo.rel_aporte_fip_id = 6 then (apo.aportado_clp / 1000)::integer
                          when fip.rel_categoria_id = 6 then ((apo.aportado_uf*fip.pagare)/100)::integer
                          else apo.aportado_uf::integer
                          end as monto_uf
                          ,case
                          when apo.rel_aporte_fip_id = 6 then 1000
                          else m.valor
                          end as valor_uf
                          ,'Aporte' as Concepto,apo.fecha
                          ,apo.saldo_cuotas::integer saldo_cuotas
                          from trabajo__aportes_FIP apo
                          inner join vw_pagos pag on pag.rel_aporte_fip_id = apo.id
                          inner join trabajo__Monedas_Valor m on apo.fecha_uf = m.fecha
                          inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
                          where CASE
                                    WHEN apo.fecha_liquidar IS NOT NULL THEN
                                      (apo.fecha_liquidar  >= date '".$this->get_cierre_mes($month, $year)['end_date']."'::date - interval '2 days' OR
                                        apo.fecha_liquidar >= date '".$this->get_cierre_mes($month, $year)['end_date']."'::date + interval '2 days')
                                ELSE
                                  apo.estado_pago = '1'                
                            END
                          and pag.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                          and rel_cliente_id = ".$id_cliente."
                
                          union all
                
                          select apo.rel_cliente_id,
                          apo.rel_aporte_fip_id,
                          dev.monto_clp*-1 monto_clp,
                          dev.monto_uf*-1 monto_uf,
                          pat.valor_cuota valor_uf,
                          tip.tipo_devolucion concepto,
                          dev.fecha_pago fecha, 
                          dev.saldo_cuotas saldo_cuotas
                          from trabajo__Devolucion dev
                          inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                          inner join trabajo__Monedas_Valor m on dev.fecha_uf = m.fecha
                          inner join trabajo__Monedas_Valor m_apo on apo.fecha_uf = m_apo.fecha
                          inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                          inner join trabajo__Patrimonio pat on date(date_trunc('month',pat.fecha)+'2month'::interval-'1day'::interval) = date(date_trunc('month',dev.fecha_pago)+'1month'::interval-'1day'::interval) and pat.rel_fip_id = apo.rel_aporte_fip_id
                          where rel_cliente_id = ".$id_cliente."
                          and dev.rel_tipo_devolucion_id = 1
                          and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                          
                          union all
                
                          select apo.rel_cliente_id,apo.rel_aporte_fip_id,dev.monto_clp
                          ,0 monto_uf
                          ,0 valor_uf,tip.tipo_devolucion concepto,dev.fecha_pago fecha
                          ,0 saldo_cuotas
                          from trabajo__Devolucion dev
                          inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                          inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                          
                          where rel_cliente_id = ".$id_cliente."
                          and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                          and dev.rel_tipo_devolucion_id = 2
                
                          union all
                
                          select apo.rel_cliente_id,apo.rel_aporte_fip_id,((apo.aportado_clp*(100-fip.pagare))/100)::integer monto_clp
                          ,((apo.aportado_uf*(100-fip.pagare))/100)::integer monto_uf
                          ,m.valor valor_uf
                          ,'Pagaré' concepto,apo.fecha
                          ,case
                           when apo.rel_aporte_fip_id = 24 then apo.aportado_uf * 0.98
                           when apo.rel_aporte_fip_id = 25 then apo.valor_contable
                           end as saldo_cuotas
                          from trabajo__aportes_FIP apo
                          inner join trabajo__FIP fip on fip.id = apo.rel_aporte_fip_id
                          inner join trabajo__Monedas_Valor m on apo.fecha_uf = m.fecha
                          where rel_cliente_id = ".$id_cliente."
                          and apo.estado_pago = '1'
                          and fip.rel_categoria_id = 6
                          
                        )a
                
                        full join(
                          select apo.rel_aporte_fip_id
                          ,case
                          when apo.rel_aporte_fip_id = 6 then (sum(dev.monto_clp))/1000
                          else  
                            CASE
                              WHEN tip.tipo_devolucion = 'Pago Final' THEN
                                sum(dev.monto_uf)
                              ELSE
                                0
                            END
                          end as capital_pagado_uf
                          ,sum(dev.monto_clp)capital_pagado_clp
                          from trabajo__Devolucion dev
                          inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                          inner join trabajo__tipo_devolucion tip on dev.rel_tipo_devolucion_id = tip.id
                          full join trabajo__Patrimonio pat on date(date_trunc('month',pat.fecha)+'2month'::interval-'1day'::interval) = date(date_trunc('month',dev.fecha_pago)+'1month'::interval-'1day'::interval)  and pat.rel_fip_id = apo.rel_aporte_fip_id
                          where rel_tipo_devolucion_id = 1
                          and apo.rel_cliente_id = ".$id_cliente."
                          and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                          group by 1,tip.tipo_devolucion
                        )b on a.rel_aporte_fip_id = b.rel_aporte_fip_id
                
                        full join(
                          select apo.rel_aporte_fip_id,sum(dev.monto_uf)dev_cap_pag
                          from trabajo__Devolucion dev
                          inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                          inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                
                          where rel_cliente_id = ".$id_cliente."
                          and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                          and dev.rel_tipo_devolucion_id = 4
                          group by 1
                        )c on a.rel_aporte_fip_id = c.rel_aporte_fip_id
                
                        full join(
                          select apo.rel_aporte_fip_id,sum(dev.monto_clp)dev_int_pag
                          from trabajo__Devolucion dev
                          inner join trabajo__aportes_FIP apo on apo.id = dev.rel_aporte_fip_id
                          inner join trabajo__Tipo_Devolucion tip on tip.id = dev.rel_tipo_devolucion_id
                
                          where rel_cliente_id = ".$id_cliente."
                          and dev.fecha_pago <= '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                          and dev.rel_tipo_devolucion_id = 5
                          group by 1
                        )d on a.rel_aporte_fip_id = c.rel_aporte_fip_id
                
                        full join trabajo__Monedas_Valor mon_per on mon_per.fecha = '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                
                
                        full join (
                          select *
                          from trabajo__Patrimonio pat
                          where date(date_trunc('month',pat.fecha)+'1month'::interval-'1day'::interval) = '".$this->get_cierre_mes($month, $year)['end_date']."'::date
                        )pat on pat.rel_fip_id = a.rel_aporte_fip_id
                        inner join trabajo__FIP fip on fip.id = a.rel_aporte_fip_id
                        where a.rel_cliente_id = ".$id_cliente."
                        and a.concepto in ('Aporte','Pagaré')
                        order by fip.inicio
                    )a
                    group by 1,2, a.rel_cliente_id
                    order by 1";
        return $this->intranet->query($query)->result_array();
    }

    public function getEstadoAporte($id_aporte)
    {
        $query = "select taf.estado_pago from trabajo__aportes_fip taf where taf.id = ".$id_aporte;
        $result = $this->db->query($query)->result_array();
        return $result['estado_pago'];
    }

    public function get_cierre_mes($month = NULL, $year = NULL)
    {

        if(is_null($month) && is_null($year))
        {
            $result['start_date']   =   '2017-01-01';
            $result['end_date']     =   '2017-01-31';
            
            $query = "select date(date_trunc('month', current_date)+'0month'::interval-'1day'::interval)";
            $result['end_date']     =   $this->intranet->query($query)->result_array()[0]['date'];
            $query = "select date(date_trunc('month', current_date)+'-1month'::interval-'1day'::interval)";
            $result['start_date']   =   $this->intranet->query($query)->result_array()[0]['date'];

            return $result;
        }else{
            
            $result['end_date']     =   date("Y-m-t",strtotime("01-".$month."-".$year));
            $result['start_date']   =   $year.'-'.$month.'-01';
            
            return $result;
        }
    }

    public function get_fecha_primer_aporte($id_cliente)
    {
        $query = "select fecha from trabajo__aportes_fip where rel_cliente_id = ".$id_cliente." ORDER BY fecha ASC LIMIT 1;";

        $result = $this->intranet->query($query)->result_array();
        if(count($result ) > 0)
        {

        }

        return $this->intranet->query($query)->result_array()[0]['fecha'];
    }

    public function get_valores_cuota($fecha)
    {
        $query = "select count(*) as cantidad from trabajo__patrimonio where fecha = '".$fecha."';";
        return $this->intranet->query($query)->result_array()[0]['cantidad'];
    }

    public function get_nota_cierre_fip($periodo, $id_fip)
    {
        $query = "SELECT html_comentario as comentario FROM trabajo__fipnotacierremes WHERE fecha_cierre ='".$periodo['end_date']."'and rel_fip_id_id = ".$id_fip;
        return $this->intranet->query($query)->result_array();
    }

    public function get_fipinfoextra($fecha, $id_fip, $call = null)
    {
        $date_periodo = new DateTime($fecha['end_date']);
        $query = "select * from trabajo__fipinfoextra WHERE periodo_cartola = '".$date_periodo->format('m-Y')."' AND rel_fip_id = ".$id_fip;
        if(!is_null($call)){
          $query .= " AND call = ".$call;
        }

        return $this->intranet->query($query)->result_array();
    }
}