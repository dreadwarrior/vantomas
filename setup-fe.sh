#!/usr/bin/env bash

echo "Setup the Frontend dependencies"

source ".nvm/nvm.sh"

PATH="./node_modules/.bin:$PATH"

npm install
npm run-script bower-install