<?php
class ContratoWeb extends Contrato {
    private $descuento;

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente,) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRenueva, $objCliente);
        $this->descuento = 10;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

    public function calcularImporte() {
        $importeWeb = 0;
        $importePlan = parent::calcularImporte();
        $descuentoAplicado = $importePlan * ($this->descuento / 100);
        $importeWeb = $importePlan - $descuentoAplicado;
        return $importeWeb ;
    }

    public function __toString() {
        return parent::__toString() . "Descuento: " . $this->getDescuento() . "%\n";
    }
}

