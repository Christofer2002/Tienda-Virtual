<?php

require '../config/search.php';

$columns = ['id', 'nombre', 'descripcion', 'precio'];
$table = 'ropa';

$campo = isset($_POST['campo']) ? $conexion->real_escape_string($_POST['campo']) : null;

$where = '';

if($campo != null){
    $where = "WHERE (";
    $cont = count($conlums);
    for($i = 0; $i < $cont; $i++){
        $where .= $conlums[$i]. "";
    }
}

$sql = "SELECT " . implode(", ", $columns) . " FROM  $table";
$resultado = $conexion->query($sql);
$num_rows = $resultado->num_rows;

$html = '';

if($num_rows > 0){
    while($row = $resultado->FETCH_ASSOC()){
        $html .= '<div class="grid">';
        $html .= '<div id="content" class="shadow">';
        $html .= '<div class="container__fluid">';
        $html .= '<div class="container__fluid--img">';
        $html .= '<img src="../img/' . $row['id'] . '.jpg" alt="">';
        $html .= '</div>';
        $html .= '<div class="container__fluid--info">';
        $html .= '<h3>' . $row['nombre'] . '</h3>';
        $html .= '<p>' . $row['descripcion'] . '</p>';
        $html .= '<p>' . $row['precio'] . '</p>';
        $html .= '</div>';
        $html .= '</div>';
    }
}else{
        $html .= '<p>No hay resultados</p>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>