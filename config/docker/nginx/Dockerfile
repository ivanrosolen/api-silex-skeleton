FROM nginx:stable

# copy carrefour-web-view static files
COPY . /var/www/html/

# copy nginx custom configs
COPY ./config/docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./config/docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
