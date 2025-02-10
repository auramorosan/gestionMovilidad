<?php
// Apertura de los archivos en modo read
$vehiculos = fopen('vehiculos.txt', 'r');
$servicios = fopen('servicios.txt', 'r');
$logistica = fopen('logistica.txt', 'r');
$vehiculosEMT = fopen('vehiculosEMT.txt', 'r');
$residentesYHoteles = fopen('residentesYhoteles.txt', 'r');
$taxis = fopen('taxis.txt', 'r');

// Verificación de apertura exitosa de los archivos
if (!$vehiculos || !$servicios || !$logistica || !$vehiculosEMT || !$residentesYHoteles || !$taxis){
    die("ERROR: No se pudo abrir uno o más archivos.");
}

$coincidencias = [];

// Método para verificar coincidencias entre una línea del archivo vehiculos y un archivo de los otros
function compararLineaConArchivo($lineaVehiculo, $archivo){
    rewind($archivo); // Reiniciar el puntero al inicio
    while ($linea = fgets($archivo)){
        $linea = trim($linea); // Eliminar espacios en blanco
        if(empty($linea)){
            continue; // Saltar líneas vacías
        }
        // Extraer matrículas
        $matriculaVehiculo = explode(' ', $lineaVehiculo)[0];
        $matriculaComparar = explode(' ', $linea)[0];
        // Comparar matrículas
        if ($matriculaVehiculo == $matriculaComparar) {
            return true; // Coincidencia encontrada
        }
    }
    return false; // No hay coincidencia
}
// Leer archivo de vehículos y comparar
while(!feof($vehiculos)){ //continúa mientras no se haya alcanzado el final del archivo
    $lineaVehiculo = fgets($vehiculos); //lee una linea completa del archivo
    if ($lineaVehiculo){ // Evitar procesar líneas vacías
        $lineaVehiculo = trim($lineaVehiculo);
        // Verificar si la línea tiene "electrico"
        if(strpos($lineaVehiculo, 'electrico') !== false){
            continue; // Ignorar si el vehículo es eléctrico
        }
        // Comparar con cada archivo
        if (!compararLineaConArchivo($lineaVehiculo, $servicios) &&
            !compararLineaConArchivo($lineaVehiculo, $logistica) &&
            !compararLineaConArchivo($lineaVehiculo, $vehiculosEMT) &&
            !compararLineaConArchivo($lineaVehiculo, $residentesYHoteles)&&
            !compararLineaConArchivo($lineaVehiculo, $taxis)&&
            !in_array($lineaVehiculo, $coincidencias)){
                $coincidencias[] = $lineaVehiculo; // Agregar al array si no hay coincidencias
        }
    }
}

fclose($vehiculos);
fclose($servicios);
fclose($logistica);
fclose($vehiculosEMT);
fclose($residentesYHoteles);

// Mostrar resultados
if(!empty($coincidencias)){
    echo "Vehículos no autorizados:<br/>";
    foreach ($coincidencias as $coincidencia){
        echo $coincidencia . "<br/>";
    }
}else{
    echo "No se encontraron vehículos no autorizados.";
}
?>
