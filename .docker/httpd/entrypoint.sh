#!/bin/sh

# marvambass/nginx-ssl-secure container entrypoint.sh
#
# based on https://github.com/MarvAmBass/docker-nginx-ssl-secure/blob/f39196e3791f19758ff50167028de7a1e1cacb0f/entrypoint.sh
#
# Changes:
# - /bin/sh instead of /bin/bash to allow running in alpine
# - set -e for early exiting on error
# - create directory and parents for $DH
# - removal of file copying

set -e

cat <<EOF
Welcome to the marvambass/nginx-ssl-secure container

IMPORTANT:
  IF you use SSL inside your personal NGINX-config,
  you should add the Strict-Transport-Security header like:

    # only this domain
    add_header Strict-Transport-Security "max-age=31536000";
    # apply also on subdomains
    add_header Strict-Transport-Security "max-age=31536000; includeSubdomains";

  to your config.
  After this you should gain a A+ Grade on the Qualys SSL Test

EOF

if [ -z "${DH_SIZE+x}" ]
then
  >&2 echo "==> no \$DH_SIZE specified using default"
  DH_SIZE="2048"
fi


DH="/etc/nginx/external/dh.pem"

if [ ! -e "$DH" ]
then
  echo "==> seems like the first start of nginx, doing some preparations..."
  mkdir -p "$(dirname $DH)"

  echo "==> generating $DH with size: $DH_SIZE"
  openssl dhparam -out "$DH" $DH_SIZE
fi

if [ ! -e "/etc/nginx/external/cert.pem" ] || [ ! -e "/etc/nginx/external/key.pem" ]
then
  echo "==> generating self signed cert"
  openssl req -x509 -newkey rsa:4086 \
    -subj "/C=XX/ST=XXXX/L=XXXX/O=XXXX/CN=localhost" \
    -keyout "/etc/nginx/external/key.pem" \
    -out "/etc/nginx/external/cert.pem" \
    -days 3650 -nodes -sha256
fi

# exec CMD
echo "==> exec docker CMD"
echo "$@"
exec "$@"
