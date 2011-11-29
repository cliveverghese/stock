#!/bin/bash

while [ 1 -lt 10 ]
do
	echo "updatin"
	php stock_update.php
	echo "done"
	sleep 60

done
