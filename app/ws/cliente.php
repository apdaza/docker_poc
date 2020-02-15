<?php
error_reporting(E_ALL);
require_once ('../clases/nusoap/nusoap.php');
//Give it value at parameter 
$param = array('your_name' => 'Alejandro');
//Create object that referer a web services 
$client = new nusoap_client('http://localhost:8080/pncav_stand/ws/financiero.php?wsdl');
//Call a function at server and send parameters too 
//$response = $client->call('get_message', $param);
//
////Process result 
//if ($client->fault) {
//    echo "FAULT: <p>Code: (" . $client->faultcode . "</p>";
//    echo "String: " . $client->faultstring;
//} else {
//    echo $response;
//}
//
//echo "<hr>";

////Give it value at parameter 
//$param = array('Nombre' => 'Alejandro Daza','Edad'=>25,'Sexo'=>'Masculino');
////Call a function at server and send parameters too 
//$result = $client->call('IniciarSorteo', array('Persona' => $param));
////Process result 
//if ($client->fault) {
//    echo "FAULT: <p>Code: (" . $client->faultcode . "</p>";
//    echo "String: " . $client->faultstring;
//} else {
//    echo $result['saludo']." ganador: ".$result['ganador'];
//}
//echo "<hr>";

$param = array('idInterventor' => '10');
$result = $client->call('ConsultaFinanciera',$param);
//Process result 
if ($client->fault) {
    echo "FAULT: <p>Code: (" . $client->faultcode . "</p>";
    echo "String: " . $client->faultstring;
} else {
    echo $result['Ano']." valor -> ".$result['ValorContratoOperdor'];
}
//echo "<hr>";
//    echo '<h2>Request</h2>';
//    echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//    echo '<h2>Response</h2>';
//    echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
//    // Display the debug messages
//    echo '<h2>Debug</h2>';
    echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?> 
