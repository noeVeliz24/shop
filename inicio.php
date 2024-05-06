<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz CRUD</title>
    <link rel="stylesheet" href="styles.css">
    <script src="java.js"></script>
</head>
<body>
    <h1>Lista de Artículos</h1>
    <table id="tabla-articulos">
        <thead>
            <tr>
                <th>Número</th>
                <th>Capacidad</th>
                <th>Color</th>
                <th>Modelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conexión a la base de datos
            $conexion = new mysqli('localhost', 'root', '', 'aeropuerto2');

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Consulta a la base de datos
            $sql = "SELECT * FROM aviones";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar los datos en la tabla
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["numero"] . "</td>";
                    echo "<td>" . $row["capacidad"] . "</td>";
                    echo "<td>" . $row["color"] . "</td>";
                    echo "<td>" . $row["modelo"] . "</td>";
                    echo "<td><a href='editar.php?id=" . $row["id"] . "'>Editar</a> | <a href='eliminar.php?id=" . $row["id"] . "'>Eliminar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay registros</td></tr>";
            }
            $conexion->close();
            ?>
        </tbody>
    </table>
    <h2>Agregar Nuevo Avión</h2>
    <div id="formulario">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero">
            <label for="capacidad">Capacidad:</label>
            <input type="text" id="capacidad" name="capacidad">
            <label for="color">Color:</label>
            <input type="text" id="color" name="color">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo">
            <button type="submit" id="btn-agregar">Agregar</button>
        </form>
    </div>

    <?php
    // Procesar el formulario para agregar un nuevo avión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexión a la base de datos
        $conexion = new mysqli('localhost', 'root', '', 'aeropuerto2');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Obtener los datos del formulario
        $numero = $_POST["numero"];
        $capacidad = $_POST["capacidad"];
        $color = $_POST["color"];
        $modelo = $_POST["modelo"];

        // Preparar la consulta SQL para insertar un nuevo avión
        $sql = "INSERT INTO aviones (numero, capacidad, color, modelo) VALUES (?, ?, ?, ?)";

        // Preparar la sentencia SQL
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            // Asociar parámetros y ejecutar la sentencia
            $stmt->bind_param("iiss", $numero, $capacidad, $color, $modelo);
            $stmt->execute();

            // Verificar si se insertó el avión correctamente
            if ($stmt->affected_rows > 0) {
                echo "<p>Avión agregado correctamente.</p>";
            } else {
                echo "<p>Error al agregar el avión.</p>";
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "<p>Error en la preparación de la consulta: " . $conexion->error . "</p>";
        }

        // Cerrar la conexión
        $conexion->close();
        
    }
    
    ?>
</body>
</html>
