include ${HTTP_TO_HTTPS_REDIRECT};

server {
    listen ${NGINX_LISTEN_PORT};

    include ${SSL_CONFIG};

    add_header 'Access-Control-Allow-Origin' '*';
    add_header 'Access-Control-Allow-Credentials' 'true';
    add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, DELETE, OPTIONS';
    add_header 'Access-Control-Allow-Headers' 'Accept,Authorization,Authorization,Cache-Control,Content-Type,DNT,If-Modified-Since,Keep-Alive,Origin,User-Agent,X-Mx-ReqToken,X-Requested-With,X-Authorization';

    if ($request_method = 'OPTIONS') {
        return 204;
    }

    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header   Host $host;
    }

    location ~ /\.ht { deny  all; }
    location ~ /\.hg { deny  all; }
    location ~ /\.svn { deny  all; }
}
