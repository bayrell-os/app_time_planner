#!/bin/bash

#URL="http://127.0.0.1/api/targets/9/edit/"
URL="http://127.0.0.1/api/targets/9/delete/"
#URL="http://127.0.0.1/api/targets/create/"

DATA='{"data":{"name": "Название цели 21"}}'

echo $URL"\n"
curl -d "$DATA" -H "Content-Type: application/json" \
    -X DELETE $URL

