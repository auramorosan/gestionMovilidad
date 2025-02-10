<?php
// Archivo: gestionLogistica.php

// Verificar que la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'] ?? null;
    $empresa = $_POST['empresa'] ?? null;

    // Limpiar los datos
    $matricula = trim($matricula);
    $empresa = trim($empresa);

    // Validar los datos
    $errores = [];

    // Validar matrícula
    if (!preg_match('/^[0-9]{4}-[A-Z]{3}$/', $matricula)) {
        $errores['matricula'] = "La matrícula no es válida. Debe tener el formato 0000-AAA.";
    }

    // Validar empresa (debe contener solo letras, números y espacios)
    if (empty($empresa) || !preg_match('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/', $empresa)) {
        $errores['empresa'] = "El nombre de la empresa no es válido. Debe contener solo letras, números y espacios.";
    }

    // Si hay errores, repintar el formulario
    if (!empty($errores)) {
        // No se debe usar "exit;" si queremos continuar con la repintada del formulario
        include('procesarFormulario.php'); // Aquí invocas el formulario con los valores previos y errores
        exit; // Detiene el script para que no continue procesando
    }

    // Formato para guardar los datos
    $linea = sprintf("%s %s\n", $matricula, str_replace(' ', '_', $empresa));

    // Guardar en el archivo logistica.txt
    $rutaArchivo = 'logistica.txt';

    // Abrir el archivo en modo "a" (apéndice) para añadir al final
    $archivo = fopen($rutaArchivo, 'a');
    if ($archivo) {
        if (fwrite($archivo, $linea)) {
            echo"Los datos se han guardado correctamente.";
        } else {
            echo "Hubo un error al escribir los datos.";
        }
        fclose($archivo); // Cerrar archivo
    } else {
        echo "Hubo un error al abrir el archivo.";
    }
}
?>
