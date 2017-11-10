#!/usr/bin/env bash

set -ef

conf="/etc/nginx/conf.d"
ssl_cert="/certs/domain.crt"
vars='\$NGINX_LISTEN_PORT \$SSL_CONFIG \$HTTP_TO_HTTPS_REDIRECT'

if [ -f $ssl_cert ]; then
   NGINX_LISTEN_PORT="443 ssl"
   SSL_CONFIG="https_config.conf"
   HTTP_TO_HTTPS_REDIRECT="http_to_https_redirect.conf"
fi

export NGINX_LISTEN_PORT=${NGINX_LISTEN_PORT:-80} \
       HTTP_TO_HTTPS_REDIRECT=${HTTP_TO_HTTPS_REDIRECT:-empty.conf} \
       SSL_CONFIG=${SSL_CONFIG:-empty.conf}

if [ -n "$USE_CORS_PROXY" ]; then
    envsubst "$vars" < "$conf/cors_proxy.tpl" > "$conf/cors_proxy.conf"

    export HTTP_TO_HTTPS_REDIRECT="empty.conf" \
           SSL_CONFIG="empty.conf" \
           NGINX_LISTEN_PORT=8080
fi

envsubst "$vars" < "$conf/default.tpl" > "$conf/default.conf"

nginx -g 'daemon off;'
