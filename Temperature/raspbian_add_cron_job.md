# Add cron job

Type `crontab -e`, add the following text, change '28-041780f40cff' to the
correct sensor identity, save the file and exit your editor.

    */5 * * * * python /home/pi/Raspberry/Temperature/temperature_logger.py 28-041780f40cff
