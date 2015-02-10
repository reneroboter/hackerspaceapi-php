#!/bin/bash
cd $(dirname $0)
php spacestatus.php > status_new.json && mv status_new.json status.json
