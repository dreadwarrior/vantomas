#!/usr/bin/env bash

echo "Setup the Frontend dependencies"

source ".nvm/nvm.sh"

PATH="./node_modules/.bin:$PATH"

if [ $(nvm current) = "none" ]; then
    nvm install
fi

npm install
npm run-script bower-install