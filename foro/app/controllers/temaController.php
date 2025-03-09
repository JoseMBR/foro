<?php
// app/controllers/temaController.php - Lógica para temas con paginación

// Iniciar sesión solo si no está ya activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Usar __DIR__ para incluir correctamente el archivo de conexión
require_once __DIR__ . '/../../config/db.php';

class TemaController {
    // Lista los temas con paginación: recibe el número de página y la cantidad por página.
    public function listar($pagina = 1, $por_pagina = 10) {
        global $pdo;
        $inicio = ($pagina - 1) * $por_pagina;
        // Actualizamos la cláusula ON para usar u.id en lugar de u.id_usuario
        $stmt = $pdo->prepare("SELECT t.*, u.nombre AS autor FROM temas t JOIN usuarios u ON t.usuario_id = u.id ORDER BY t.fecha_creacion DESC LIMIT :inicio, :por_pagina");
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Retorna la cantidad total de temas.
    public function contar() {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM temas");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>
