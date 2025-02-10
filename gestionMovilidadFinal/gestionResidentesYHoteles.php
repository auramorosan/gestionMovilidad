<?php
// Archivo: gestionResidentesYHoteles.php

// Verificar que la solicitud es POST y que se enviaron los datos esperados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'] ?? null;
    $tipoPermiso = $_POST['tipoPermiso'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $fechaInicio = $_POST['fechaInicio'] ?? null;
    $fechaFin = $_POST['fechaFin'] ?? null;
    $fichero = $_FILES['fichero'] ?? null;

    // Validar los datos recibidos
    $errores = [];

    // Validar matrícula
    if (!preg_match('/^[0-9]{4}-[A-Z]{3}$/', $matricula)) {
        $errores[] = "La matrícula no es válida. Debe tener el formato 0000-AAA.";
    }

    // Validar tipo de permiso
    if (!in_array($tipoPermiso, ['residencia', 'hotel'])) {
        $errores[] = "El tipo de permiso no es válido.";
    }

    // Validar fechas
    $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fechaInicio);
    $fechaFinObj = DateTime::createFromFormat('Y-m-d', $fechaFin);

    if (!$fechaInicioObj || !$fechaFinObj) {
        $errores[] = "Las fechas no son válidas.";
    } elseif ($fechaInicioObj > $fechaFinObj) {
        $errores[] = "La fecha de inicio no puede ser posterior a la fecha de fin.";
    }

    // Validar fichero subido (PDF obligatorio)
    if (!$fichero || $fichero['error'] != 0 || pathinfo($fichero['name'], PATHINFO_EXTENSION) != 'pdf') {
        $errores[] = "El justificante debe ser un archivo PDF válido.";
    }

    // Si hay errores, mostrar mensaje y detener ejecución
    if (!empty($errores)) {
        echo "Se encontraron errores en el formulario:<br>";
        foreach ($errores as $error) {
            echo "- $error<br>";
        }
        exit;
    }

    // Formato para guardar la información
    $linea = sprintf(
        "%s %s %s %s\n",
        $matricula,
        str_replace(' ', '_', $direccion), // Reemplazar espacios por guiones bajos en la dirección
        $fechaInicio,
        $fechaFin
    );

    // Guardar en el archivo residentesYhoteles.txt
    $rutaArchivo = 'residentesYhoteles.txt';

    // Abrir el archivo en modo "apéndice" (a), que añade datos al final del archivo
    $archivo = fopen($rutaArchivo, 'a');
    if ($archivo) {
        // Escribir la línea en el archivo
        if (fwrite($archivo, $linea)) {
            echo "Los datos se han guardado correctamente.";
        } else {
            echo "Hubo un error al escribir los datos.";
        }
        // Cerrar el archivo
        fclose($archivo);
    } else {
        echo "Hubo un error al abrir el archivo.";
    }
}
?>
