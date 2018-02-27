#!/usr/bin/env python

"""Raspberry Pi Temperature Database Logger"""

import os
import MySQLdb
import sys

os.system('sudo modprobe w1-gpio')
os.system('sudo modprobe w1-therm')

db = MySQLdb.connect(user="webusername", passwd="webpassword", db="web")
cur = db.cursor()

if len(sys.argv) > 1:
    sensor_path = "/sys/bus/w1/devices/"
    sensor_id_list = sys.argv[1:]
else:
    sensor_path = "/home/pi/Raspberry/Temperature/test/"
    sensor_id_list = ["99-999999999999"]

for sensor_id in sensor_id_list:
    sensor_file = open(sensor_path + sensor_id + "/w1_slave", "r")
    sensor_lines = sensor_file.readlines()
    sensor_file.close()
    sensor_output = sensor_lines[1].find("t=")
    if sensor_output != -1:
        sensor_val = float(sensor_lines[1].strip()[sensor_output+2:])/1000.0
    else:
        sensor_val = -273.16
    sensor_val = round(sensor_val, 2)
    sql = "INSERT INTO temperature (sensor_id,sensor_val) VALUES (" \
          + "'" + sensor_id + "'," + str(sensor_val) + ")"
    try:
        cur.execute(sql)
        db.commit()
    except:
        db.rollback()

cur.close()
db.close()
