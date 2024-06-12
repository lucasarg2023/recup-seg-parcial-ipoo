<?php

class ContratoEmpresa extends Contrato {

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente,) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente);
    }



    public function calcularImporte() {
        $importeTotal = parent::calcularImporte();
        foreach ($this->getObjPlan()->getColCanales() as $canal) {
            $importeTotal += $canal->getImporte();
        }
        return $importeTotal;
    }

    public function __toString() {
        return parent::__toString();
    }
}