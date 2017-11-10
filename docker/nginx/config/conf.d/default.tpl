include ${HTTP_TO_HTTPS_REDIRECT};

server {
    listen ${NGINX_LISTEN_PORT};

    include ${SSL_CONFIG};

    root /srv;

    client_max_body_size 20M;

    gzip             on;
    gzip_comp_level  2;
    gzip_min_length  1000;
    gzip_proxied     expired no-cache no-store private auth;
    gzip_types       text/plain application/x-javascript application/javascript text/xml text/css application/xml;


    location ~* ^/(_profiler|_wdt|api)/.* {
        fastcgi_pass php:9000;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME    /app/app.php;
        fastcgi_param  SCRIPT_NAME        app.php;
    }

    location / {

    }
}
