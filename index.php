<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador de Servicios - Constructora Miranda</title>
</head>
<body>
    <h2>Cotizador - Constructora Miranda</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">Nombre del cliente</label>
        <input type="text" id="nombre" name="nombre">
        <br><br>

        <label for="ciudad">Ciudad:</label>
        <select id="ciudad" name="ciudad">
            <option value="">Seleccione...</option>
            <option value="Quito">Quito</option>
            <option value="Guayaquil">Guayaquil</option>
            <option value="Cuenca">Cuenca</option>
            <option value="Ambato">Ambato</option>
            <option value="Manta">Manta</option>
        </select><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono"><br><br>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo"><br><br>

        <fieldset>
            <legend>Tono deseado para la remodelación:</legend>
            <input type="checkbox" id="claro" name="tono[]" value="1">
            <label for="claro">Claro</label>

            <input type="checkbox" id="neutro" name="tono[]" value="2">
            <label for="neutro">Neutro</label>

            <input type="checkbox" id="oscuro" name="tono[]" value="3">
            <label for="oscuro">Oscuro</label>
        </fieldset>

        <h3>Servicios de remodelación</h3>
        <label for="pintura">Habitaciones a pintar ($150 c/u):</label>
        <input type="number" name="pintura" min="0" value="0"><br><br>

        <label for="galones">Galones de pintura SUPREMO ($18 c/u):</label>
        <input type="number" name="galones" min="0" value="0"><br><br>

        <label for="grietas">Reparación de grietas ($20 c/u):</label>
        <input type="number" name="grietas" min="0" value="0"><br><br>

        <label for="limpieza">¿Desea limpieza final? ($20):</label>
        <input type="checkbox" name="limpieza" value="1"><br><br>

        <input type="submit" value="Calcular cotización">
    </form>

<?php
    //require_once 'funciones.php'; // Incluyo el archivo de funciones
    function limpiar($dato){
    $dato = trim($dato);//eliminar espacion en blanco al inicio y final
    $dato = stripslashes($dato);//devuele el dato con las barras investidad
    $dato = htmlspecialchars($dato);//convierte los caracteres especiales en entidades html
    return $dato;
    }

    echo "</br></br>";
    if($_SERVER['REQUEST_METHOD']==="POST"){//me aseguro que el usuario hizo el sumit 
        
        $nombre =!empty($_POST['nombre'])? limpiar($_POST["nombre"]):"";
        $ciudad = isset($_POST['ciudad'])? limpiar($_POST["ciudad"]):"";
        $telefono =!empty($_POST['telefono'])? limpiar($_POST["telefono"]):"";
        $correo =!empty($_POST['correo'])? limpiar($_POST["correo"]):"";
        $tones= isset($_POST['tono'])?$_POST['tono']:array();
        $pintura = (int) ($_POST["pintura"] ?? 0);
        $galones = (int) ($_POST["galones"] ?? 0);
        $grietas = (int) ($_POST["grietas"] ?? 0);
        $limpieza = isset($_POST["limpieza"]) ? 1 : 0;
        //mostrar error 
        $errores = array();
        if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
        if (empty($ciudad)) $errores[] = "Seleccione una ciudad.";
        if (empty($telefono)) $errores[] = "Ingrese su teléfono.";
        if (empty($correo)) $errores[] = "Ingrese su correo electrónico.";
        if(empty($tones)) $errores []="Debes seleccionar al menos un tipo de tono";
        if(!empty($errores)){
            echo "<h3>Errores encontrados </h3>";
            echo "<ul>";
            foreach($errores as $error){
                echo "<li>{$error}</li>";
            }
            echo "</ul>";
        }else{//no hay errores 
            // Procesar cotización
            $total = ($pintura * 150) + ($galones * 18) + ($grietas * 20);
            if ($limpieza) $total += 20;

            echo "<h3>Resumen de Cotización</h3>";
            echo "<p><strong>Nombre:</strong> $nombre</p>";
            echo "<p><strong>Ciudad:</strong> $ciudad</p>";
            echo "<p><strong>Teléfono:</strong> $telefono</p>";
            echo "<p><strong>Correo electronico:</strong> $correo</p>";
            if(!empty($tones)){
                echo "<p><strong>Tono seleccionado:</strong></p>";
                foreach($tones as $to){
                    switch ($to){
                        case '1':
                            echo  "<p>Claro</p>";
                            break;
                            case '2':
                            echo  "<p>Neutro</p>";
                            break;
                            case '3':
                            echo  "<p>Oscuro</p>";
                            break;
                            default:
                            break;
                    }
                }
            }else{
               echo "<p>No has seleccionado suscripciones.</p>";
            }
            echo "<ul>";
            echo "<li><strong>Pintura:</strong> $pintura habitación(es) → $" . ($pintura * 150) . "</li>";
            echo "<li><strong>Galones de pintura:</strong> $galones → $" . ($galones * 18) . "</li>";
            echo "<li><strong>Reparación de grietas:</strong> $grietas → $" . ($grietas * 20) . "</li>";
            echo "<li><strong>Limpieza final:</strong> " . ($limpieza ? "$20" : "No") . "</li>";
            echo "</ul>";
            echo "<h3>Total a pagar: <span style='color:green;'>$$total</span></h3>";
        
        }
    }
?>
</body>
</html>
