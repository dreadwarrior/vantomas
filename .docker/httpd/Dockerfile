FROM alpine:3.4

MAINTAINER Thomas Juhnke <dev@van-tomas.de>

RUN apk add --no-cache --virtual .nginx \
    nginx \
    openssl \
    # forward request and error logs to docker log collector
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

COPY conf /

ADD entrypoint.sh /opt/entrypoint.sh
RUN chmod a+x /opt/entrypoint.sh

EXPOSE 80 443

VOLUME ["/app"]

ENTRYPOINT ["/opt/entrypoint.sh"]

CMD ["nginx", "-g", "daemon off;"]
