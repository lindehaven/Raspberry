#!/usr/bin/env bash
let "temperature=$RANDOM-16383"
echo "bd 01 4b 46 7f ff 03 10 ff : crc=ff YES" > $1
echo "bd 01 4b 46 7f ff 03 10 ff t=$temperature" >> $1
