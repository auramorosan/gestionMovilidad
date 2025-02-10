<?php
// formulario dinamico
$tipoFormulario = $_POST['tipoFormulario'] ?? '';
//el operador (??) verifica si el valor a la izquierda, en este caso $_POST['tipoFormulario']) existe y no es nulo.
//Si existe y no es nulo, devuelve su valor y si no existe o es nulo, devuelve el valor de la derecha del operador ('').
$archivoGestion = 'defaultGestion.php';

switch ($tipoFormulario) {
    case 'servicios':
        $archivoGestion = 'gestionServicios.php';
        break;
    case 'vehiculosEMT':
        $archivoGestion = 'gestionVehiculosEMT.php';
        break;
    case 'taxis':
        $archivoGestion = 'gestionTaxis.php';
        break;
    case 'residentesYHoteles':
        $archivoGestion = 'gestionResidentesYHoteles.php';
        break;
    case 'logistica':
        $archivoGestion = 'gestionLogistica.php';
        break;
    default:
        echo "Error en el archivo de gestion!";
}

echo "<form method='POST' action='$archivoGestion' enctype='multipart/form-data'>
        Matricula vehiculo (0000-AAA): <input type='text' name='matricula' value='".($_POST['matricula'] ?? '') ."' required><br><br>";

    // Verificar si hay errores y mostrarlos
    if (isset($errores['matricula'])) {
        echo "<span style='color:red;'>".$errores['matricula']."</span><br><br>";
    }
    //segun el tipo de formulario, se procesan unos datos u otros
    if ($tipoFormulario == 'servicios') {
        echo "Tipo de Vehículo: <input type='text' name='tipoVehiculo'
        value='" . (isset($_POST['tipoVehiculo']) ? $_POST['tipoVehiculo'] : '') . "' required><br><br>";
    } elseif ($tipoFormulario == 'vehiculosEMT') {
        echo "Linea: <input type='text' name='linea'
        value='" . (isset($_POST['linea']) ? $_POST['linea'] : '') . "' required><br><br>";
    } elseif ($tipoFormulario == 'taxis') {
        echo "Nombre: <input type='text' name='nombre'
        value='". (isset($_POST['nombre']) ? $_POST['nombre'] : '') . "' required><br><br>";
    } elseif ($tipoFormulario == 'residentesYHoteles') {
        echo "Tipo de permiso:
            <select name='tipoPermiso' required>
                <option value='residencia'". (isset($_POST['tipoPermiso']) &&
                 $_POST['tipoPermiso'] == 'residencia' ? 'selected' : '') . ">Residencia</option>
                <option value='hotel'". (isset($_POST['tipoPermiso']) &&
                 $_POST['tipoPermiso'] == 'hotel' ? 'selected' : '') . ">Hotel</option>
            </select><br><br>
            Direccion de residencia: <input type='text' name='direccion'
                value='". (isset($_POST['direccion']) ? $_POST['direccion'] : '') . "' required><br><br>
            Fecha de inicio: <input type='date' name='fechaInicio'
                value='" . (isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : '') . "' required><br><br>
            Fecha de fin: <input type='date' name='fechaFin'
                value='" . (isset($_POST['fechaFin']) ? $_POST['fechaFin'] : '') . "' required><br><br>
            Justificante de residencia o reserva de hotel (PDF): <input type='file' name='fichero' accept='.pdf' required><br><br>";
    } elseif ($tipoFormulario == 'logistica') {
        echo "Empresa: <input type='text' name='empresa'
        value='" . (isset($_POST['empresa']) ? $_POST['empresa'] : '') . "' required><br><br>";
    }

echo "<button type='submit'>Guardar</button>
</form>";
?>
