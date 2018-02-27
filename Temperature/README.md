# Temperature

This project measures the temperature using a Maxim DS18B20 1-wire sensor,
stores the temperature in a Maria DB and displays temperatures on an Apache
web page.

I used the project "Raspberry Pi Temperature Sensor: Build a DS18B20 Circuit
https://pimylifeup.com/raspberry-pi-temperature-sensor/ and added a database
and a web server.

## Equipment

* Raspberry Pi
* Maxim DS18B20 temperature sensor
* Resistor 4.7 Kohm (or some value 1.5 - 5.6 Kohm).

Connect the DS18B20 temperature sensor and get the correct sensor identity, see
https://pimylifeup.com/raspberry-pi-temperature-sensor/

## Installation

* Install 'Temperature':
  ```
  cd /home/pi
  git clone https://github.com/lindehaven/Raspberry.git
  cd Raspberry/Temperature
  sudo cp -r www/html/* /var/www/html/.
  ```
* Install Apache, Maria DB and PHP, see `raspbian_lamp_install.txt`. Set the
username and password that you want.
* Setup Maria DB, see `raspbian_maria_db_setup.txt`. Set the username and
password that you want.
* Add cron job and change '28-041780f40cff' to the correct sensor identity,
see `raspbian_add_cron_job.txt`.
* Edit `/var/www/html/index.php` and change '28-041780f40cff' to the correct
sensor identity.

## Function

`temperature_logger.py` reads the temperature from the DS18B20 and stores the
value in the Maria DB. Temperatures can be displayed via the Apache web page.

The web page displays the current temperature, lowest temperature, average
temperature and highest temperature for the selected period.

The current temperature of the Raspberry Pi CPU and GPU are also displayed.

* http://ip-address:port/index.php
  Displays temperatures for today.
* http://ip-address:port/index.php?d=YYYY-MM-DD
  Displays temperatures for a specific day (YYYY-MM-DD).
* http://ip-address:port/index.php?m=YYYY-MM
  Displays temperatures for a specific month (YYYY-MM).
* http://ip-address:port/index.php?y=YYYY
  Displays temperatures for a specific year (YYYY).
