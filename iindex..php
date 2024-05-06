<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stilos.css">
    <script src="scripts.js"></script>

    <title>Clientes</title>
   
</head>
<body>
    
    <div class="container">
        <table border="2">
        <h2>aeropuerto</h2>
        <details>
            
            <summary>Agregar Cliente</summary>
            <form id="addForm">
            <div class="fondo-personalizado"> 
                <label for="numero">Nombre de la empresa:</label>
                <input type="text" id="numero" name="numero"><br><br>
                
                <label for="direccionAdd">Dirección:</label>
                <input type="text" id="direccionAdd" name="direccionAdd"><br><br>
                
                <label for="telefonoAdd">Teléfono:</label>
                <input type="text" id="telefonoAdd" name="telefonoAdd"><br><br>
                
                <label for="correoAdd">Correo:</label>
                <input type="text" id="correoAdd" name="correoAdd"><br><br>
                
                <button type="button" onclick="agregarCliente()">Agregar Cliente</button>
            </div>
            </form>
        </details>
        <div class="fondo-personalizado">
    <div id="panel-edicion" class="panel-edicion" style="display: none;">
        <h2>Editar Cliente</h2>
        <form id="editForm">
            <input type="hidden" id="idEditar" name="idEditar">
            <label for="nombreEmpresaEdit">Nombre de la empresa:</label>
            <input type="text" id="nombreEmpresaEdit" name="nombreEmpresaEdit"><br><br>
            
            <label for="direccionEdit">Dirección:</label>
            <input type="text" id="direccionEdit" name="direccionEdit"><br><br>
            
            <label for="telefonoEdit">Teléfono:</label>
            <input type="text" id="telefonoEdit" name="telefonoEdit"><br><br>
            
            <label for="correoEdit">Correo:</label>
            <input type="text" id="correoEdit" name="correoEdit"><br><br>
            
            <button type="button" onclick="guardarCambiosCliente()">Guardar Cambios</button>
            <button type="button" onclick="ocultarFormularioEditar()">Salir</button>
        </form>
    </div>
    </div>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Empresa</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th> <!-- Nueva columna para los botones de editar y eliminar -->
                </tr>
            </thead>
            <tbody>
                <?php
                $canal = curl_init();
                $url = 'http://localhost:8081/aeropuerto/Back%20end/get_all_avion.php';
                curl_setopt($canal, CURLOPT_URL, $url);
                curl_setopt($canal, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($canal);

                if (curl_errno($canal)) {
                    $error_msg = curl_error($canal);
                    echo "<tr><td colspan='6'>Error en la conexión: $error_msg</td></tr>";
                } else {
                    curl_close($canal);

                    $clientes = json_decode($respuesta, true);
                    foreach ($clientes as $cliente) {
                        echo "<tr>";
                        echo "<td>{$cliente['id']}</td>";
                        echo "<td>{$cliente['numero']}</td>";
                        echo "<td>{$cliente['capacidad']}</td>";
                        echo "<td>{$cliente['color']}</td>";
                        echo "<td>{$cliente['modelo']}</td>";
                        echo "<td>
                                <button onclick=\"mostrarFormularioEditar({$cliente['id']}, '{$cliente['numero']}', '{$cliente['capacidad']}', '{$cliente['color']}', '{$cliente['modelo']}')\">Editar</button>
                                <button onclick=\"eliminarCliente({$cliente['id']})\">Eliminar</button></td>";
                                
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Panel de Edición -->
   

    <script>
        function mostrarFormularioEditar(id, nombreEmpresa, direccion, telefono, correo) {
            document.getElementById('id').value = id;
            document.getElementById('numero').value = nombreEmpresa;
            document.getElementById('capacidad').value = direccion;
            document.getElementById('color').value = telefono;
            document.getElementById('modelo').value = correo;

            document.getElementById('panel-edicion').style.display = 'block';
        }

        function ocultarFormularioEditar() {
            document.getElementById('panel-edicion').style.display = 'none';
        }

        function guardarCambiosCliente() {
            var id = document.getElementById('id').value;
            var nombreEmpresa = document.getElementById('numero').value;
            var direccion = document.getElementById('capacidad').value;
            var telefono = document.getElementById('color').value;
            var correo = document.getElementById('modelo').value;

            var url = 'http://localhost:8081/aeropuerto/update_avion.php' + id +
                      '&numero=' + encodeURIComponent(nombreEmpresa) +
                      '&capacidad=' + encodeURIComponent(direccion) +
                      '&color=' + encodeURIComponent(telefono) +
                      '&modelo=' + encodeURIComponent(correo);

            fetch(url, {
                method: 'PUT'
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("No se pudo editar el cliente.");
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
            });
        }
        
        function eliminarCliente(id) {
            if (confirm("¿Está seguro de que desea eliminar este cliente?")) {
                fetch('http://localhost:8081/aeropuerto/delete_avion.php?id' + id, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert("No se pudo eliminar el cliente.");
                    }
                })
                .catch(error => {
                    console.error('Error al enviar la solicitud:', error);
                });
            }
        }
        function agregarCliente() {
            var nombreEmpresa = document.getElementById("numero").value;
            var direccion = document.getElementById("capacidad").value;
            var telefono = document.getElementById("color").value;
            var correo = document.getElementById("modelo").value;

            var url = 'http://localhost:8081/aeropuerto/create_avion.php=' + encodeURIComponent(nombreEmpresa) + '&numero=' + encodeURIComponent(direccion) + '&capacidad=' + encodeURIComponent(telefono) + '&color=' + encodeURIComponent(correo);

            fetch(url, {
                method: 'POST'
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("No se pudo agregar el cliente.");
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
            });
        }
    </script>
</body>
</html>
