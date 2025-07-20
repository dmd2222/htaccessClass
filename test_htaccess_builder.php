<?php
require_once 'HtaccessBuilderClass.php';

$testFilePath = __DIR__ . '/.htaccess';

$builder = new HtaccessBuilder();

$builder
    ->forceHttps()
    ->urlRewrite([
        'artikel/([0-9]+)' => 'artikel.php?id=$1',
        'kontakt' => 'kontakt.html'
    ])
    ->passwordProtect('/var/www/.htpasswd')  // Pfad zu deiner .htpasswd-Datei anpassen
    ->ipWhitelist(['127.0.0.1'])
    ->ipBlacklist(['203.0.113.1'])
    ->customErrorPages([
        404 => '/error/404.html',
        403 => '/error/403.html'
    ])
    ->disableDirectoryListing()
    ->enableGzip()
    ->setCaching(14)
    ->setSecurityHeaders([
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains'
    ])
    ->enableCORS([
        'origin' => '*',
        'methods' => 'GET, POST, OPTIONS',
        'headers' => 'Content-Type, Authorization'
    ])
    ->build($testFilePath);

$success = file_exists($testFilePath);
$contents = $success ? file_get_contents($testFilePath) : '';

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>HtaccessBuilder Testseite</title>
    <style>
        body { font-family: sans-serif; margin: 2em; }
        pre { background: #f0f0f0; padding: 1em; border: 1px solid #ccc; }
        .status { font-weight: bold; color: <?= $success ? 'green' : 'red' ?>; }
    </style>
</head>
<body>
    <h1>Test der HtaccessBuilder-Klasse</h1>

    <p class="status">
        <?= $success ? '? .htaccess wurde erfolgreich erstellt.' : '? Fehler beim Erstellen der .htaccess.test-Datei.' ?>
    </p>

    <h2>Inhalt der generierten .htaccess-Datei:</h2>
    <pre><?= htmlspecialchars($contents) ?></pre>

    <h2>Hinweise:</h2>
    <ul>
        <li>Diese Datei sollte nicht live im Root-Verzeichnis einer echten Website liegen.</li>
        <li>Bitte �berpr�fe, ob dein Server `.htaccess` und die verwendeten Apache-Module unterst�tzt.</li>
        <li>Wenn du die Datei produktiv einsetzen willst, benenne <code>.htaccess.test</code> in <code>.htaccess</code> um.</li>
        <li>Setze den Pfad zur <code>.htpasswd</code>-Datei korrekt (aktuell: <code>/var/www/.htpasswd</code>).</li>
    </ul>
</body>
</html>
