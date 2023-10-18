<?php
    date_default_timezone_set('Asia/Hong_Kong');
    session_start();
    
    require_once "vendor/autoload.php";

    use Dotenv\Dotenv;
    use Ramsey\Uuid\Uuid;
    use App\Utils\DatabaseConnection;
    use App\Utils\SystemFunctions;
    use App\Utils\RedirectPage;

    $dotenv = Dotenv::createImmutable(__DIR__.'/config');
    $dotenv->load();

    $database = New DatabaseConnection($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    
    $functions = New SystemFunctions();

    $redirect = New RedirectPage();

    define("RANDOM_ID", Uuid::uuid4()->toString());
    define("SYSTEM_URL", $_ENV['SYSTEM_URL']);
    define("TODAYS", date("Y-m-d H:i:s"));