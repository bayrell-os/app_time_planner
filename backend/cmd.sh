#!/bin/bash

if [ -f env/bin/activate ]; then
    source env/bin/activate
fi

SCRIPT=$(readlink -f $0)
SCRIPT_PATH=`dirname $SCRIPT`
BASE_PATH=`dirname $SCRIPT_PATH`
RETVAL=0

case "$1" in
    pip)
        pip3 ${@:2}
    ;;
    run)
        python3 ./main.py
    ;;
    freeze)
        pip3 freeze > requirements.txt
    ;;
    download)
        pip download -r requirements.txt -d env/packages/
    ;;
    create_env)
        python3 -m venv env
    ;;
    *)
		echo "Usage: $0 {run|pip|freeze|download|create_env}"
		RETVAL=1
esac

exit $RETVAL