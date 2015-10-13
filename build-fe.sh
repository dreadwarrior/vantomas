#!/usr/bin/env bash

echo "Build the Frontend dependencies"

source ".nvm/nvm.sh"

PATH="./node_modules/.bin:$PATH"

if [ $(nvm current) = "none" ]; then
    nvm install
fi

npm run-script grunt-build