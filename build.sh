#!/bin/bash
# Usage:
#   ./build.sh
#   ./build.sh install       — installs prerequisites
#   ./build.sh build         — build only
#   ./build.sh start         — starts the symfony server
#   ./build.sh stop          — stops the symfony server

set -e

LOCAL_PORT="8001"

usage() {
    echo "Usage: $0 [install|build|start|stop]"
    echo ""
    echo "  install    Installs the prerequisites"
    echo "  build      Builds the app"
    echo "  start      Starts the symfony server"
    echo "  stop       Stops the symfony server"
    echo ""
    exit 1
}


# ── Install ────────────────────────────────────────────────────────────
function cmd_install() {
    composer install
    # yarn install
}
# ── Build ────────────────────────────────────────────────────────────
function cmd_build() {
    # yarn build
    true
}
# ── Package ───────────────────────────────────────────────────────────────────
function app_package() {
    [[ ! -d "dist" ]] && { echo "Creating dist/"; mkdir dist; }
    [[ -f "dist/district24.zip" ]] && { echo "Removing old zip"; rm dist/*.zip; }
    zip -r dist/district24.zip css js index.html -x "*.DS_Store"
}

# ── Deploy targets ────────────────────────────────────────────────────────────
function cmd_start() {
  symfony server:start --port=$LOCAL_PORT -d
}

function cmd_stop() {
  symfony server:stop
}

function cmd_docker() {
    docker build -t area75 .
    # Stop and remove any existing container with the same name
    docker rm -f area75 2>/dev/null || true
#    docker run -d -p $LOCAL_PORT:80 --name district24 district24
    echo "Running at http://localhost:$LOCAL_PORT"
}

# ── Entry point ───────────────────────────────────────────────────────────────
[[ $# -ne 1 ]] && usage

case "$1" in
    install)    cmd_install  ;;
    build)      cmd_build    ;;
    start)      cmd_start    ;;
    stop)       cmd_stop     ;;
    *)          usage        ;;
esac
