#!/usr/bin/env bash

echo "Build the Frontend dependencies"

source ".nvm/nvm.sh"

PATH="./node_modules/.bin:$PATH"

npm run-script grunt-build