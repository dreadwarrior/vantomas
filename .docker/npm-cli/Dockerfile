FROM alpine:3.4

MAINTAINER Thomas Juhnke <dev@van-tomas.de>

RUN apk add --no-cache --virtual .npm-cli \
        nodejs \
        g++ \
        python \
        make \
    && npm -g install npm@~3.3.8 \
    && adduser -g '' -s /bin/false -D npm

VOLUME ["/home/npm/.npm"]

USER npm

ENTRYPOINT ["npm"]
