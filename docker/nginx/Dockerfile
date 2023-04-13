FROM nginx:1.23.3

COPY ./docker/nginx/conf.d /etc/nginx/conf.d
RUN rm /etc/nginx/conf.d/default.conf

WORKDIR /var/www

# Следующая строка может быть не правильной
COPY ./ ./

RUN cd web && chmod 777 img