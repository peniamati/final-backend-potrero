<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Configuración del correo electrónico
    $to = "pena_matias@hotmail.com";
    $subject = "Nuevo mensaje de contacto";
    $body = "Nombre: $nombre\nEmail: $email\n\nMensaje:\n$mensaje";

    // Headers para evitar problemas de seguridad
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Intento de envío del correo
    if (mail($to, $subject, $body, $headers)) {
        $response = ['status' => 'success', 'message' => 'Mensaje enviado correctamente.'];
    } else {
        // Obtener el último error generado por el sistema de correo
        $errorMessage = error_get_last()['message'];
        $response = ['status' => 'error', 'message' => 'Error al enviar el mensaje: ' . $errorMessage];
    }

    // Configurar la cabecera de la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
