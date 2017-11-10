FROM nginx:1.11-alpine

COPY config /etc/nginx/
COPY web /srv/
COPY boot.sh /usr/local/bin/boot_nginx

CMD ["sh", "/usr/local/bin/boot_nginx"]
