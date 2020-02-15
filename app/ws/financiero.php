<?php
require_once ('../config/ws_conf.php');
//using soap_server to create server object 
$server = new soap_server;
$server->configureWSDL("Financiero", "urn:financierowsdl");
$server->wsdl->schemaTargetNamespace = "urn:financierowsdl";

// create the function 
//function get_message($your_name) {
//    if (!$your_name) {
//        return new soap_fault('Client', '', 'Put Your Name!');
//    }
//    $result = "Welcome to " . $your_name . ". Thanks for Your First Web Service Using PHP with SOAP";
//    return $result;
//}
//
//function IniciarSorteo($persona) {
//    $Saludo = 'Hola, ' . trim($persona['Nombre']) . '. ';
//    $Saludo .= 'Usted tiene ' . $persona['Edad'] . ' ';
//    $Saludo .= 'años y es ' . trim($persona['Sexo']) . '. ';
//    
//    
//    return array(
//        'saludo' => $Saludo,
//        'ganador' => (bool) rand(0, 1)
//    );
//}

function ConsultaFinanciera($idInterventor){
    $info = NULL;
    //conectar();
    $result = ejecutarConsulta("select ope_contrato_no, ope_contrato_valor, ope_contrato_anio from operador where ope_id = 1");
    if($result){
         $w = mysqli_fetch_array($result);
        $info = array(
                'IdInterventor' => ID_INTERVENTOR,
                'NumeroContrato' =>  $w['ope_contrato_no'],
                'Ano' =>  $w['ope_contrato_anio'],
                'ValorContratoOperdor' =>  $w['ope_contrato_valor'],
                'FechaFirmaContrato' =>"1900-01-01",
                'ValorAdicion' =>0,
                'FechaProrrogaAdicion' => "1900-01-01",
                'ValorDesembolso' => 0,
                'FechaPagoDesembolso' => "1900-01-01",
                'ValorAnticipo' => 0,
                'FechaAnticipo' =>"1900-01-01",
                'ValorUtilizacion' => 0,
                'NumeroActaAprobacion' => "123",
                'FechaUtilizacion' =>"1900-01-01",
                'Valorrendimiento' => 0,
                'FechaRendimiento' =>"1900-01-01",
                'NumeroComprobanteRendimiento' => "123",
                'ValorComision' => 0,
                'FechaComision' =>"1900-01-01",
                'ValorGastosAdministrativos' => 0,
                'FechaGastosAdministrativos' =>"1900-01-01",
                'NombreFiducia' => "FB",
                'NumeroContratoFiducia' => 0,
                'FechaContratoFiducia' => "1900-01-01",
                'FechaProrrogaAdicionFiducia' => "1900-01-01" ,
                'MarcaTiempo' => "1900-01-01T00:00:00"
        );
    }else{
        $info = array(
                'IdInterventor' => ID_INTERVENTOR,
                'NumeroContrato' =>  0,
                'ValorContratoOperdor' =>  0,
                'Ano' =>  0
//                'FechaFirmaContrato' =>"1900-01-01",
//                'ValorAdicion' =>0,
//                'FechaProrrogaAdicion' => "1900-01-01",
//                'ValorDesembolso' => 0,
//                'FechaPagoDesembolso' => "1900-01-01",
//                'ValorAnticipo' => 0,
//                'FechaAnticipo' =>"1900-01-01",
//                'ValorUtilizacion' => 0,
//                'NumeroActaAprobacion' => "123",
//                'FechaUtilizacion' =>"1900-01-01",
//                'Valorrendimiento' => 0,
//                'FechaRendimiento' =>"1900-01-01",
//                'NumeroComprobanteRendimiento' => "123",
//                'ValorComision' => 0,
//                'FechaComision' =>"1900-01-01",
//                'ValorGastosAdministrativos' => 0,
//                'FechaGastosAdministrativos' =>"1900-01-01",
//                'NombreFiducia' => "FB",
//                'NumeroContratoFiducia' => 0,
//                'FechaContratoFiducia' => "1900-01-01",
//                'FechaProrrogaAdicionFiducia' => "1900-01-01" ,
//                'MarcaTiempo' => "1900-01-01T00:00:00"
        );
    }
    return $info;
}

//function GetPersonas() {
//    $List = array();
//
//    $Sexo = array(
//        0 => "Hombre",
//        1 => "Mujer"
//    );
//
//    for ($i = 1; $i < 11; $i++) {
//        $List[$i]['Nombre'] = "Persona " . $i;
//        $List[$i]['Edad'] = rand(1, 100);
//        $List[$i]['Sexo'] = $Sexo[rand(0, 1)];
//    }
//
//    return $List;
//}

//definicion de tipos
//$server->wsdl->addComplexType(
//        'TWsPersona', 'complexType', 'struct', 'all', '', array(
//    'Nombre' => array('name' => 'Nombre', 'type' => 'xsd:string'),
//    'Edad' => array('name' => 'Edad', 'type' => 'xsd:int'),
//    'Sexo' => array('name' => 'Sexo', 'type' => 'xsd:string')
//        )
//);
//
//$server->wsdl->addComplexType(
//        'TWsResultadoSorteo', 'complexType', 'struct', 'all', '', array(
//    'saludo' => array('name' => 'saludo', 'type' => 'xsd:string'),
//    'ganador' => array('name' => 'ganador', 'type' => 'xsd:boolean')
//        )
//);

//$server->wsdl->addComplexType(
//        'TWsEntradaFinanciera', 
//        'complexType', 
//        'struct', 
//        'all', 
//        '', 
//        array(
//            'idInterventor' => array('name' => 'idInterventor', 'type' => 'xsd:string'),
//            'marca' => array('name' => 'marca', 'type' => 'xsd:string')  
//        )
//);

$server->wsdl->addComplexType(
        'AspectosFinancieros', 
        'complexType', 
        'struct', 
        'all', 
        '', 
        array(
            'IdInterventor' => array('name' => 'IdInterventor', 'type' => 'xsd:string'),
            'NumeroContrato' => array('name' => 'NumeroContrato', 'type' => 'xsd:int'),
            'ValorContratoOperdor' => array('name' => 'ValorContratoOperdor', 'type' => 'xsd:int'),
            'Ano' =>  array('name' => 'Ano', 'type' => 'xsd:int'),
            'FechaFirmaContrato' => array('name' => 'FechaFirmaContrato', 'type' => 'xsd:string'),
            'ValorAdicion'   => array('name' => 'ValorAdicion', 'type' => 'xsd:int'),
            'FechaProrrogaAdicion'  => array('name' => 'FechaProrrogaAdicion', 'type' => 'xsd:string'),
            'ValorDesembolso'  => array('name' => 'ValorDesembolso', 'type' => "xsd:int"),
            'FechaPagoDesembolso'  => array('name' => 'FechaProrrogaAdicion', 'type' => 'xsd:string'),
            'ValorAnticipo'  => array('name' => 'ValorDesembolso', 'type' => "xsd:int"),
            'FechaAnticipo'  => array('name' => 'FechaProrrogaAdicion', 'type' => 'xsd:string'),
           ' ValorUtilizacion'  => array('name' => 'ValorDesembolso', 'type' => "xsd:int"),
           ' NumeroActaAprobacion'  => array('name' => 'NumeroActaAprobacion', 'type' => 'xsd:string'),
            'FechaUtilizacion'  => array('name' => 'FechaUtilizacion', 'type' => 'xsd:string'),
            'FechaRendimiento' => array('name' => 'FechaRendimiento', 'type' => 'xsd:string'),
           'NumeroComprobanteRendimiento' => array('name' => 'NumeroComprobanteRendimiento', 'type' => 'xsd:string'),
            'ValorComision' => array('name' => 'ValorComision', 'type' => 'xsd:int'),
            'FechaComision' => array('name' => 'FechaComision', 'type' => 'xsd:string'),
            'ValorGastosAdministrativos' => array('name' => 'ValorGastosAdministrativos', 'type' => 'xsd:int'),
            'FechaGastosAdministrativos'  => array('name' => 'FechaGastosAdministrativos', 'type' => 'xsd:string'),
            'NombreFiducia'  => array('name' => 'NombreFiducia', 'type' => 'xsd:string'),
            'NumeroContratoFiducia'  => array('name' => 'NumeroContratoFiducia', 'type' => 'xsd:int'),
            'FechaContratoFiducia' => array('name' => 'FechaContratoFiducia', 'type' => 'xsd:string'),
            'FechaProrrogaAdicionFiducia'  => array('name' => 'FechaProrrogaAdicionFiducia', 'type' => 'xsd:string'),
            'MarcaTiempo'  => array('name' => 'MarcaTiempo', 'type' => 'xsd:datetime')
        )
);

//$server->wsdl->addComplexType(
//        'TWsArrayOfPersona', 'complexType', 'array', '', 'SOAP-ENC:Array', array(), array(
//    array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:TWsPersona[]')
//        ), 'tns:TWsPersona'
//);

//register a function that works on server 
//$server->register(
//        'get_message', // Nombre del método
//        array('your_name' => 'xsd:string'), // Parámetros de entrada
//        array('return' => 'xsd:string'), // Parámetros de salida
//        'urn:financierowsdl', // Nombre del workspace
//        'urn:financierowsdl#get_message', // Acción soap
//        'rpc', // Estilo
//        'encoded', // Uso
//        'Saluda a la persona'                       // Documentación
//);
//
//$server->register(
//        'IniciarSorteo', // Nombre del método
//        array('Persona' => 'tns:TWsPersona'), // Parámetros de entrada
//        array('return' => 'tns:TWsResultadoSorteo'), // Parámetros de salida
//        'urn:financierowsdl', // Nombre del workspace
//        'urn:financierowsdl#IniciarSorteo', // Acción soap
//        'rpc', // style
//        'encoded', // Uso
//        'Saludar y devuelve el resultado del sorteo'    // Documentación
//);

$server->register(
        'ConsultaFinanciera', // Nombre del método
       array('idInterventor' => 'xsd:string'), // Parámetros de entrada
        array('return' => 'tns:AspectosFinancieros'), // Parámetros de salida
        'urn:financierowsdl', // Nombre del workspace
        'urn:financierowsdl#ConsultaFinanciera', // Acción soap
        'rpc', // style
        'encoded', // Uso
        'Consulta la informacion de contratos'    // Documentación
);

//$server->register(
//        'GetPersonas', // Nombre del método
//        array(), // Parámetros de entrada
//        array('return' => 'tns:TWsArrayOfPersona'), // Parámetros de salida
//        'urn:holamundowsdl', // Nombre del workspace
//        'urn:holamundowsdl#GetPersonas', // Acción soap
//        'rpc', // style
//        'encoded', // Uso
//        'Devuelve un array de personas'                // Documentación
//);

// create HTTP listener 
$post = file_get_contents('php://input');
$server->service($post);
exit();
?>

