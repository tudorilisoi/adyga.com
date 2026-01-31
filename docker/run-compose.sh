#!/bin/bash
script_path=$(dirname "$(readlink -f "$0")")
COMPOSE_CMD="docker compose --env-file "$script_path/docker-compose.env" -f "$script_path/docker-compose.yml""
export HOST_UID=$(id -u)
export HOST_GID=$(id -g)
export USERNAME=$(whoami)
export USERNAME=$(whoami)
set +e
source "$script_path/check_rootless_mode.sh"
ROOTLESS=$?
echo "rootless: $ROOTLESS"

export ROOTLESS_DOCKER='no'
if [ $ROOTLESS -eq 0 ]; then
    # docker rootless maps these back to user UID/GUID
    #   echo "set HOST_UID/HOST_GID to 0 for rootless compat"
    #   export HOST_UID=0
    #   export HOST_GID=0
    export ROOTLESS_DOCKER='yes'
fi

if grep -sq 'docker\|lxc' /proc/1/cgroup; then
    echo "Cannot run inside a container"
    exit 1
fi

EXTRA_ARGS="-d"

if [ "$1" == "dev" ]; then
    echo "Running development command"
    export WEB_MEM_LIMIT="4G"
    export WEB_CMD='yarn run dev:1-blitz'
elif [ "$1" == "start" ]; then
    echo "Running start command"
    #export WEB_CMD="node /app/node_modules/.bin/blitz start"
elif [ "$1" == "stop" ]; then
    echo "Running stop command"
    $COMPOSE_CMD down 2>&1
    exit 0
elif [ "$1" == "logs" ]; then
    echo "Running logs command"
    $COMPOSE_CMD logs -f
    exit 0
else
    echo "Invalid argument. Usage: $0 [dev|start|stop|logs]"
    exit 1
fi

$COMPOSE_CMD down 2>&1
$COMPOSE_CMD up --build $EXTRA_ARGS
