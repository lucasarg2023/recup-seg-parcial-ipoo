<?php


require_once 'EmpresaCable.php';
require_once 'Canal.php';
require_once 'Plan.php';
require_once 'Cliente.php';
require_once 'Contrato.php';
require_once 'ContratoWeb.php';
require_once 'ContratoEmpresa.php';

// instancia EmpresaCable
$empresa = new EmpresaCable();

// Se crean 3 instancias de la clase Canal.

$canal1 = new Canal("Noticias", 10, true, true);
$canal2 = new Canal("Deportivo", 15, false, false);
$canal3 = new Canal("Películas", 20, true, false);
$colCanales =[ $canal1 , $canal2 , $canal3];

//c) Se crean 2 instancias de la clase Planes, cada una de ellas con su código propio que hacen referencia a los canales creados anteriormente (uno de los códigos de plan debe ser 111)
$plan1 = new Plan(111, $colCanales, 5000, false);
$plan2 = new Plan(222, $colCanales, 7000, true);
$colplanes =[ $plan1, $plan2];

//d) Crear una instancia de la clase Cliente
$cliente = new Cliente("Nombre del Cliente", "123456789", "av argentina 546");

//  e) Se crean 3 instancias de Contratos, 1 correspondiente a un contrato realizado en la empresa y 2 realizados via web.
$contrato1 = new Contrato ('30-5-2020','30-6-2020', $plan1, 5000, false, $cliente);
$contrato2 = new Contrato ('30-2-2020','30-3-2020', $plan2, 7000, true, $cliente);
$contrato3 =new Contrato ('30-1-2020','30-2-2020', $plan1, 5000, false, $cliente);

// f) Invocar con cada instancia del inciso anterior al método calcularImporte y visualizar el resultado.
echo "Importe contrato 1: " . $contrato1->calcularImporte() . "\n";
echo "Importe contrato 2: " . $contrato2->calcularImporte() . "\n";
echo "Importe contrato 3: " . $contrato3->calcularImporte() . "\n";

//g) Invocar al método incorporaPlan con uno de los planes creados en c).
$nuevoPlan1 = $empresa->incorporarPlan($plan1);

// h) Invocar nuevamente al método incorporaPlan de la empresa con el plan creado en c).
$nuevoPlan2= $empresa->incorporarPlan($plan1);

/* i) Invocar al método incorporarContrato con los siguientes parámetros: uno de los planes creado en c),
el cliente creado en e), la fecha de hoy para indicar el inicio del contrato, la fecha de hoy más 30 días
para indicar el vencimiento del mismo y false como último parámetro. */
$empresa->incorporarContrato($plan1, $cliente, date('Y-m-d'), date('Y-m-d', strtotime('+30 days')), false);

/*j) Invocar al método incorporarContrato con los siguientes parámetros: uno de los planes creado en c),
el cliente creado en e), la fecha de hoy para indicar el inicio del contrato, la fecha de hoy más 30 días
para indicar el vencimiento del mismo y true como último parámetro.*/
$empresa->incorporarContrato($plan2, $cliente, date('Y-m-d'), date('Y-m-d', strtotime('+30 days')), true);

//k) Invocar al método pagarContrato que recibe como parámetro uno de los contratos creados en d) y que haya sido contratado en la empresa
$empresa->pagarContrato($contrato1);

// l) Invocar al método pagarContrato que recibe como parámetro uno de los contratos creados en d) y que haya sido contratado vía web.
$empresa->pagarContrato($contrato2);

// m) invoca al método retornarImporteContratos con el código 111.
$importeContratos = $empresa->retornarImporteContratos(111);
echo "Importe total contratos con código 111: " . $importeContratos . "\n";