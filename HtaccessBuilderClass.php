<?php

class HtaccessBuilder
{
    private array $rules = [];

    public function forceHttps(bool $enable = true): self
    {
        if ($enable) {
            $this->rules[] = <<<EOT
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
EOT;
        }
        return $this;
    }

    public function urlRewrite(array $rules): self
    {
        $this->rules[] = "RewriteEngine On";
        foreach ($rules as $pattern => $target) {
            $this->rules[] = "RewriteRule ^$pattern\$ $target [L]";
        }
        return $this;
    }

    public function passwordProtect(string $htpasswdPath): self
    {
        $this->rules[] = <<<EOT
AuthType Basic
AuthName "Restricted Area"
AuthUserFile {$htpasswdPath}
Require valid-user
EOT;
        return $this;
    }

    public function ipWhitelist(array $allowedIps): self
    {
        $rules = "Order deny,allow\nDeny from all";
        foreach ($allowedIps as $ip) {
            $rules .= "\nAllow from $ip";
        }
        $this->rules[] = $rules;
        return $this;
    }

    public function ipBlacklist(array $blockedIps): self
    {
        foreach ($blockedIps as $ip) {
            $this->rules[] = "Deny from $ip";
        }
        return $this;
    }

    public function customErrorPages(array $errorPages): self
    {
        foreach ($errorPages as $code => $path) {
            $this->rules[] = "ErrorDocument $code $path";
        }
        return $this;
    }

    public function disableDirectoryListing(): self
    {
        $this->rules[] = "Options -Indexes";
        return $this;
    }

    public function enableGzip(bool $enable = true): self
    {
        if ($enable) {
            $this->rules[] = <<<EOT
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/plain text/html text/xml text/css application/javascript application/json
</IfModule>
EOT;
        }
        return $this;
    }

    public function setCaching(int $days = 7): self
    {
        $this->rules[] = <<<EOT
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresDefault "access plus {$days} days"
</IfModule>
EOT;
        return $this;
    }

    public function setSecurityHeaders(array $headers = []): self
    {
        $defaultHeaders = [
            "X-Content-Type-Options" => "nosniff",
            "X-Frame-Options" => "DENY",
            "X-XSS-Protection" => "1; mode=block",
            "Referrer-Policy" => "no-referrer",
        ];
        $headers = array_merge($defaultHeaders, $headers);

        foreach ($headers as $key => $value) {
            $this->rules[] = "Header always set \"$key\" \"$value\"";
        }
        return $this;
    }

    public function enableCORS(array $options = []): self
    {
        $origin = $options['origin'] ?? '*';
        $methods = $options['methods'] ?? 'GET, POST, OPTIONS';
        $headers = $options['headers'] ?? 'Content-Type';

        $this->rules[] = <<<EOT
<IfModule mod_headers.c>
  Header set Access-Control-Allow-Origin "$origin"
  Header set Access-Control-Allow-Methods "$methods"
  Header set Access-Control-Allow-Headers "$headers"
</IfModule>
EOT;
        return $this;
    }

    public function build(string $path = ".htaccess"): void
    {
        file_put_contents($path, implode("\n\n", $this->rules));
    }
}
