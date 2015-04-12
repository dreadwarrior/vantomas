#!/usr/bin/env bash
npm config set prefix ~/npm;
PATH="$PATH:$HOME/npm/bin"
NODE_PATH="$NODE_PATH:$HOME/npm/lib/node_modules"

npm install -g -q bower grunt-cli >/dev/null

npm install
bower install --config.interactive=false
grunt build