<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /<?php echo $subfolder;?>
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ /<?php echo $subfolder;?>index.php/$1 [L]
</IfModule>