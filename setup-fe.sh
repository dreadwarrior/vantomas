#!/usr/bin/env bash

echo "Setup the Frontend dependencies"

source ".nvm/nvm.sh"

PATH="./node_modules/.bin:$PATH"

if [ $(nvm current) = "none" ]; then
    nvm install
fi

npm install -g npm@~3.3.8
npm install
npm run-script bower-install