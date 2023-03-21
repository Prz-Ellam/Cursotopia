<?php
// Conexión a la base de datos usando PDO
$servername = "nombre_host";
$username = "nombre_usuario";
$password = "contraseña";
$dbname = "nombre_base_de_datos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Habilitar excepciones en PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Llamar al procedimiento almacenado que inserta el registro y devuelve el ID
    $stmt = $conn->prepare("CALL mi_procedimiento_almacenado(:campo1, :campo2, :campo3, @id)");
    $stmt->bindParam(':campo1', $campo1);
    $stmt->bindParam(':campo2', $campo2);
    $stmt->bindParam(':campo3', $campo3);
    
    // Asignar una variable para obtener el ID devuelto por el procedimiento almacenado
    $stmt->execute();
    $stmt->closeCursor();
    $last_id = $conn->query("SELECT @id")->fetch(PDO::FETCH_ASSOC)['@id'];
    
    echo "Registro insertado exitosamente. El ID es: " . $last_id;
}
catch(PDOException $e) {
    echo "Error al insertar registro: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
