FROM nginx:1.15

LABEL maintainer="Ilya Shashilov"

RUN rm /etc/nginx/conf.d/default.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/conf.d/*.conf /etc/nginx/conf.d/
#COPY ./web/ /srv/app/web

#RUN chown -R www-data:www-data /srv/app

CMD ["/bin/bash", "-c", "envsubst '${NGINX_HOST} ${NGINX_PORT}' < /etc/nginx/conf.d/app.conf > /etc/nginx/conf.d/app.conf && exec nginx -g 'daemon off;'"]