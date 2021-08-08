#!/bin/bash


URL="http://127.0.0.1/api/targets/8/delete/"
DATA='{"data":{"name": "Название цели 2"}}'

curl -d "$DATA" -H "Content-Type: application/json" \
    -X POST $URL

