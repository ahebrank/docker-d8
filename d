#!/bin/bash
# run whatever
. projectvars
docker exec -i -t $DRUPAL_CONTAINER bash "$@"
