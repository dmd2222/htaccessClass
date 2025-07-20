In development
-------------------------------
🇬🇧 English
HtaccessBuilder – Apache .htaccess Configuration in PHP

This class allows you to programmatically build a fully featured .htaccess file for Apache web servers using PHP. It covers rewriting rules, HTTPS enforcement, access control (password, IP whitelist/blacklist), error pages, directory listing protection, caching, GZIP compression, security headers, and CORS.
✅ Features

    Rewrite URLs (SEO-friendly)

    Enforce HTTPS

    Password protection using .htpasswd

    IP-based whitelist and blacklist

    Custom error pages (e.g. 404, 403)

    Disable directory listing

    Enable browser caching

    Enable GZIP compression

    Add secure HTTP headers

    Configure CORS

📁 Files

    HtaccessBuilder.php – the main class

    test_htaccess_builder.php – test script to generate and preview a sample .htaccess.test file

💡 Requirements

    PHP 7.4+

    Apache with enabled modules:

        mod_rewrite

        mod_headers

        mod_deflate

        mod_expires

    Write permissions in the target directory

🚀 Usage Example

require_once 'HtaccessBuilder.php';

$builder = new HtaccessBuilder();

$builder
    ->forceHttps()
    ->urlRewrite([
        'products/([0-9]+)' => 'product.php?id=$1'
    ])
    ->passwordProtect('/var/www/.htpasswd')
    ->ipWhitelist(['127.0.0.1'])
    ->customErrorPages([404 => '/errors/404.html'])
    ->disableDirectoryListing()
    ->enableGzip()
    ->setCaching(14)
    ->setSecurityHeaders()
    ->enableCORS()
    ->build('.htaccess'); // or '.htaccess.test' for safety

🧪 Testing

Run test_htaccess_builder.php in your browser. It will:

    Generate .htaccess.test

    Display success or error

    Show the full output for review

You can rename the generated file to .htaccess for use in a live server.
⚠️ Notes

    .htaccess files apply recursively to subfolders.

    Use .htaccess.test during testing to avoid conflicts.

    The .htpasswd file must exist at the given path.

    Always check Apache error logs if rules don’t behave as expected.

🇩🇪 Deutsch
HtaccessBuilder – Apache .htaccess Konfiguration mit PHP

Diese Klasse ermöglicht es dir, eine komplette .htaccess-Datei für Apache-Webserver per PHP zu erstellen. Sie unterstützt URL-Umschreibungen, HTTPS-Erzwingung, Zugriffskontrolle (Passwort, IP-Whitelist/Blacklist), Fehlerseiten, Verzeichnisschutz, Caching, GZIP-Komprimierung, Sicherheits-Header und CORS.
✅ Funktionen

    URL-Rewriting (SEO-freundlich)

    HTTPS erzwingen

    Passwortschutz per .htpasswd

    IP-Whitelist und -Blacklist

    Benutzerdefinierte Fehlerseiten (z. B. 404, 403)

    Verzeichnis-Listing verhindern

    Browser-Caching aktivieren

    GZIP-Komprimierung aktivieren

    Sicherheits-Header setzen

    CORS konfigurieren

📁 Dateien

    HtaccessBuilder.php – die Hauptklasse

    test_htaccess_builder.php – Testseite zur Erzeugung und Anzeige einer Beispiel-Datei .htaccess.test

💡 Voraussetzungen

    PHP 7.4 oder höher

    Apache mit aktivierten Modulen:

        mod_rewrite

        mod_headers

        mod_deflate

        mod_expires

    Schreibrechte im Zielverzeichnis

🚀 Beispiel zur Nutzung

require_once 'HtaccessBuilder.php';

$builder = new HtaccessBuilder();

$builder
    ->forceHttps()
    ->urlRewrite([
        'produkte/([0-9]+)' => 'produkt.php?id=$1'
    ])
    ->passwordProtect('/var/www/.htpasswd')
    ->ipWhitelist(['127.0.0.1'])
    ->customErrorPages([404 => '/fehler/404.html'])
    ->disableDirectoryListing()
    ->enableGzip()
    ->setCaching(14)
    ->setSecurityHeaders()
    ->enableCORS()
    ->build('.htaccess'); // oder '.htaccess.test' zum Testen

🧪 Testen

Starte test_htaccess_builder.php im Browser. Das Skript:

    Erstellt .htaccess.test

    Zeigt Erfolg oder Fehler an

    Gibt die komplette Konfiguration zur Überprüfung aus

Die Datei kann anschließend in .htaccess umbenannt und produktiv eingesetzt werden.
⚠️ Hinweise

    .htaccess wirkt rekursiv auf Unterverzeichnisse.

    Verwende .htaccess.test zum Testen, um Konflikte zu vermeiden.

    Die Datei .htpasswd muss existieren.

    Prüfe bei Problemen die Apache-Fehlerprotokolle.
