FROM nginx:stable-alpine

RUN rm /etc/nginx/conf.d/default.conf

ADD lwt.conf /etc/nginx/conf.d/lwt.conf

WORKDIR /etc/nginx/conf.d/
