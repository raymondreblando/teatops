<?php
    date_default_timezone_set('Asia/Hong_Kong');
    session_start();
    
    require_once "vendor/autoload.php";

    use Dotenv\Dotenv;
    use Ramsey\Uuid\Uuid;
    use App\Utils\DatabaseConnection;
    use App\Utils\EmailProcess;
    use App\Utils\SystemFunctions;
    use App\Utils\RedirectPage;

    $dotenv = Dotenv::createImmutable(__DIR__.'/config');
    $dotenv->load();

    $database = New DatabaseConnection($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

    $email_send = New EmailProcess($_ENV['EMAIL_HOST'], $_ENV['EMAIL_USERNAME'], $_ENV['EMAIL_PASSWORD'], $_ENV['EMAIL_SECURE'], $_ENV['EMAIL_PORT']);
    
    $functions = New SystemFunctions();

    $redirect = New RedirectPage();

    define("RANDOM_ID", Uuid::uuid4()->toString());
    define("SYSTEM_URL", $_ENV['SYSTEM_URL']);
    define("TODAYS", date("Y-m-d H:i:s"));