# Apache VirtualHost Sample

Use this as a reference for local XAMPP or Apache hosting.

## 1. Example VirtualHost (HTTP -> HTTPS)

```apache
<VirtualHost *:80>
    ServerName clinic.example.com
    Redirect permanent / https://clinic.example.com/
</VirtualHost>
```

## 2. Example VirtualHost (HTTPS)

```apache
<VirtualHost *:443>
    ServerName clinic.example.com
    DocumentRoot "/var/www/clinic_system"

    SSLEngine on
    SSLCertificateFile "/path/to/fullchain.pem"
    SSLCertificateKeyFile "/path/to/privkey.pem"

    <Directory "/var/www/clinic_system">
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/clinic_error.log
    CustomLog ${APACHE_LOG_DIR}/clinic_access.log combined
</VirtualHost>
```

## 3. XAMPP (Windows) notes

- Apache config usually at: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
- Hosts file: `C:\Windows\System32\drivers\etc\hosts`

Example hosts entry:

```text
127.0.0.1 clinic.local
```

Example XAMPP vhost:

```apache
<VirtualHost *:80>
    ServerName clinic.local
    DocumentRoot "C:/xampp/htdocs/projcet2026/clinic_system"
    <Directory "C:/xampp/htdocs/projcet2026/clinic_system">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 4. Required Apache Modules

- `rewrite_module`
- `headers_module`
- `ssl_module` (for HTTPS)

