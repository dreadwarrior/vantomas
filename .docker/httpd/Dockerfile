FROM alpine:3.4

MAINTAINER Thomas Juhnke <dev@van-tomas.de>

RUN apk add --no-cache --virtual .nginx \
    nginx \
    # forward request and error logs to docker log collector
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

COPY conf /

EXPOSE 80 443

VOLUME ["/app"]

CMD ["nginx", "-g", "daemon off;"]
