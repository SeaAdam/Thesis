<?php
spl_autoload_register(function ($class) {
    // Base directory for the namespace prefix
    $prefix = 'PHPMailer\\PHPMailer\\';
    $base_dir = __DIR__ . '/src/'; // Adjust path if needed

    // Check if the class name starts with the namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No match, return
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace namespace separators with directory separators and add .php extension
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
