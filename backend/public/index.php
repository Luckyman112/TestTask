<?php

use App\Utils\DataSeeder;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize Database Connection
try {
    $db = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    echo "Internal Server Error. Please check the logs.";
    exit;
}

// // Seed Database if required
// if (!empty($_GET['seed'])) {
//     try {
//         $seeder = new DataSeeder($db);
//         $seeder->seedDatabase(__DIR__ . '/../data.json');
//         echo "Database seeded successfully!";
//     } catch (Exception $e) {
//         error_log('Seeding failed: ' . $e->getMessage());
//         http_response_code(500);
//         echo "Seeding failed. Please check the logs.";
//     }
//     exit;
// }

// Example Route
if ($_SERVER['REQUEST_URI'] === '/products') {
    require __DIR__ . '/../src/Controllers/ProductController.php';
    $productController = new App\Controllers\ProductController(new App\Models\Product($db));
    $productController->listProducts();
    exit;
}

http_response_code(404);
echo "Page not found.";
