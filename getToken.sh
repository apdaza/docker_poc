#!/bin/bash
ps -p 1 | grep systemd >/dev/null
if [ "$?" -eq "0" ]; then 
	sudo systemctl status docker.service | grep -e running >/dev/null
	if [  "$?" -ne "0" ]; then
		sudo systemctl start docker.service
	fi
fi

ps -p 1 | grep init >/dev/null

if [ "$?" -eq "0" ]; then 
	sudo service docker status  | grep -e running >/dev/null

	if [  "$?" -ne "0" ]; then
		sudo service docker start 
	fi
fi
sudo docker-compose up -d
sudo docker-compose exec web php -f ./manageFiles/client_google.php
