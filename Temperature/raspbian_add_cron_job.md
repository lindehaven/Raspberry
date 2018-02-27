# Add cron job

Type `crontab -e`, add the following text, change '28-041780f40cff' to the
correct sensor identity, save the file and exit your editor.

    */5 * * * * /home/pi/Raspberry/Temperature/test/99-999999999999/w1_slave_test.sh /home/pi/Raspberry/Temperature/test/99-999999999999/w1_slave
    */5 * * * * /home/pi/Raspberry/Temperature/temperature_logger.py
    */5 * * * * /home/pi/Raspberry/Temperature/temperature_logger.py 28-041780f40cff
