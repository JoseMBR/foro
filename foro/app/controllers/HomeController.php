<?php
// app/controllers/HomeController.php - Controlador para la página de inicio

class HomeController {
    // Función principal que carga la vista de inicio
    public function index() {
        // Incluir la cabecera (header) de la página
        require_once VIEWS_PATH . '/header.php';
        
        // Incluir el contenido principal de la página de inicio
        require_once VIEWS_PATH . '/home.php';
        
        // Incluir el pie de página (footer)
        require_once VIEWS_PATH . '/footer.php';
    }
}
