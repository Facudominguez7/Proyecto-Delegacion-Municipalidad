<?php
require './includes/conexion.php';


$columns = ['id', 'presidente', 'ubicacion', 'nombre', 'dniPresidente'];
$table = "chacras";

$campo = isset($_POST['campo']) ? $con->real_escape_string($_POST['campo']) : null;

$sql = "SELECT " . implode(", ", $columns) . "
FROM $table ";
$resultado = $con->query($sql);
$num_rows = $resultado->$num_rows;

$output = [];
$output['data'] = '';

if ($numn_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">';
        $output['data'] .= '<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">'
         . $row['nombre'] . 
        '</td>';
        $output['data'] .= '<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">'
        . $row['presidente'] . 
        '</td>';
      
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '';
}

echo json_encode($output['data'], JSON_UNESCAPED_UNICODE);