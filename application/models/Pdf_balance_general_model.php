<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_balance_general_model extends CI_Model {

	public function listar_asiento_agrupado($n, $fec1, $fec2,$emp) {
		$query ="SELECT con_concepto_debe FROM  erp_asientos_contables where substr(con_concepto_debe,1,2)='$n' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1 union SELECT con_concepto_haber FROM erp_asientos_contables where substr(con_concepto_haber,1,2)='$n' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1 order by con_concepto_debe";
        $resultado=$this->db->query($query);
		return $resultado->result();
			
	}

	public function suma_pasivo_patrimonio($fec1, $fec2,$emp){
		$query ="SELECT(SELECT sum(con_valor_debe) as debe FROM erp_asientos_contables where (substr(con_concepto_debe,1,2)='2.' or substr(con_concepto_debe,1,2)='3.') and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1) as debe,
                (SELECT sum(con_valor_haber) as debe FROM erp_asientos_contables where (substr(con_concepto_haber,1,2)='2.' or substr(con_concepto_haber,1,2)='3.') and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1) as haber";
        $resultado=$this->db->query($query);
		return $resultado->row();
			
	}

	public function lista_una_cuenta($id,$id1){
		$query ="SELECT * FROM  erp_plan_cuentas where trim(pln_codigo)=trim('$id') or trim(pln_codigo)=trim('$id1')";
        $resultado=$this->db->query($query);
		return $resultado->row();
			
	}

	public function lista_balance_general1($cod, $fec1, $fec2, $emp) {
		$query ="SELECT (SELECT sum(con_valor_debe) FROM erp_asientos_contables a, erp_plan_cuentas c where trim(c.pln_codigo)=trim(a.con_concepto_debe) and  pln_operacion=0 and con_concepto_debe like '$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1)as debe1,
                            (SELECT sum(con_valor_haber) FROM erp_asientos_contables a, erp_plan_cuentas c where trim(c.pln_codigo)=trim(a.con_concepto_haber) and  pln_operacion=0 and con_concepto_haber like '$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1)as haber1,
                            (SELECT sum(con_valor_haber) FROM erp_asientos_contables a where not exists (select * from erp_plan_cuentas c where trim(c.pln_codigo)=trim(a.con_concepto_debe)) and con_concepto_debe like '$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1)as debe2,
                            (SELECT sum(con_valor_haber) FROM erp_asientos_contables a where not exists (select * from erp_plan_cuentas c where trim(c.pln_codigo)=trim(a.con_concepto_haber)) and con_concepto_haber like '$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1)as haber2,
                            (SELECT sum(con_valor_debe) FROM erp_asientos_contables a, erp_plan_cuentas c where trim(c.pln_codigo)=trim(a.con_concepto_debe) and  pln_operacion=1 and con_concepto_debe like '$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1)as debe3,
                            (SELECT sum(con_valor_haber) FROM erp_asientos_contables a, erp_plan_cuentas c where trim(c.pln_codigo)=trim(a.con_concepto_haber) and  pln_operacion=1 and con_concepto_haber like '$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1)as haber3";
        $resultado=$this->db->query($query);
		return $resultado->row();
			
	}

	public function suma_cuentas($cod, $fec1, $fec2,$emp) {
		$query ="SELECT(SELECT sum(con_valor_debe) as debe FROM erp_asientos_contables where con_concepto_debe='$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1) as debe,
                        (SELECT sum(con_valor_haber) as debe FROM erp_asientos_contables where con_concepto_haber='$cod' and con_fecha_emision between '$fec1' and '$fec2' and emp_id=$emp and con_estado=1) as haber";
        $resultado=$this->db->query($query);
		return $resultado->row();
			
	}
	
}

?>