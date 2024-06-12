<?php

class EmpresaCable {
    private $planes;
    private $contratos;

    public function __construct($planes, $contratos) {
        $this->planes = $planes;
        $this->contratos = $contratos;
    }

    //gets
    public function getPlanes() {
        return $this->planes;
    }

    public function getContratos() {
        return $this->contratos;
    }

    //sets
    public function setPlanes($planes) {
        $this->planes = $planes;
    }

    public function setContratos($contratos) {
        $this->contratos = $contratos;
    }

    private function obtValoresArrays($array) {
        $cadena = "";
        foreach ($array as $elementoArray) {
            $cadena = $cadena . " " . $elementoArray . "\n";
        }
        return $cadena;
    }

    public function __toString() {
        $losPlanes = $this->obtValoresArrays($this->getPlanes());
        $losContratos = $this->obtValoresArrays($this->getContratos());
        return "planes: " . $losPlanes . "\n" . "contratos: " . $losContratos . "\n";
    }


    /*
    incorporarPlan($objPlan): que incorpora a la colección de planes un nuevo plan siempre y
    cuando no haya un plan con los mismos canales y los mismos MG (en caso de que el plan
    incluyera).
    */
    public function incorporarPlan($objPlan) {
        $misplanes = $this->getPlanes();
        $planExistente = false;
    
        foreach ($misplanes as $plan) {
            if ($plan->getCodigo() == $objPlan->getCodigo()) {
                $planExistente = true;
            }
        }
    
        if (!$planExistente) {
            $misplanes[] = $objPlan;
            $this->setPlanes($misplanes);
        }
    }
   /*
   ncorporarContrato($objPlan,$objCliente,$fechaDesde,$fechaVenc,$esViaWeb): método
que recibe por parámetro el plan, una referencia al cliente, la fecha de inicio y de vencimiento del
mismo y si se trata de un contrato realizado en la empresa o via web (si el valor del parámetro es
True se trata de un contrato realizado via web)*/

    public function incorporarContrato($objPlan, $objCliente, $fechaDesde, $fechaVenc, $esViaWeb) {
        $contrato = new Contrato($fechaDesde, $fechaVenc, $objPlan, 0, false, $objCliente);

        // Actualizar est de contrato
        $contrato->actualizarEstadoContrato();

   
        $this->contratos[] = $contrato;

        return $contrato;
    }

    
    public function retornarImporteContratos($codigoPlan) {
        $importeTotal = 0;
        foreach ($this->contratos as $contrato) {
            if ($contrato->getObjPlan()->getCodigo() == $codigoPlan) {
                $importeTotal += $contrato->calcularImporte();
            }
        }
        return $importeTotal;
    }


    public function pagarContrato($objContrato) {
        $importeFinal = 0;
        $objContrato->actualizarEstadoContrato();
        if ($objContrato->getEstado() == 'AL DIA') {
            // Contrato al día
            $objContrato->setSeRenueva(true);
            $importeFinal = $objContrato->getCosto();
        } elseif ($objContrato->getEstado() == 'MOROSO') {
            // Contrato moroso, 
            $diasMora = $objContrato->diasContratoVencido();
            $montoMulta = $objContrato->getCosto() * 0.10 * $diasMora;
            $objContrato->setCosto($objContrato->getCosto() + $montoMulta);
            $objContrato->setEstado('AL DIA');
            $objContrato->setSeRenueva(true);
            $importeFinal = $objContrato->getCosto();
        } elseif ($objContrato->getEstado() == 'SUSPENDIDO') {
            // Contrato suspendido,
            $diasMora = $objContrato->diasContratoVencido();
            $montoMulta = $objContrato->getCosto() * 0.10 * $diasMora;
            $objContrato->setCosto($objContrato->getCosto() + $montoMulta);
            $importeFinal = $objContrato->getCosto();
        }
        return $importeFinal;
    }


















}
?>