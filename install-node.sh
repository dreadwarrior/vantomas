#!/usr/bin/env bash

echo "Installing node.js"

source ".nvm/nvm.sh"

PATH="./node_modules/.bin:$PATH"

nvm install