#!/bin/sh -f

ROOT_PATH=$(pwd)

echo "------------------------------------------------------------------------"
echo "-- Stop and delete executing container"
echo "------------------------------------------------------------------------"
echo ""
docker rm -f hic-agent-cz

echo "------------------------------------------------------------------------"
echo "-- Start container"
echo "------------------------------------------------------------------------"
echo ""
docker run -d \
           --restart="always" \
           --env MQTT_IP_ADDR="192.168.1.78" \
           --env MQTT_PORT_NO="1883" \
           --env MQTT_USER="NA" \
           --env MQTT_PASSWORD="NA" \
           --env SERIALPORT_BAUD_RATE="9600" \
           --env SERIALPORT_DATA_BITS="8" \
           --env SERIALPORT_STOP_BITS="1" \
           --privileged \
           --device /dev/tty-xxxx:/dev/tty-agent-cz \
           --name hic-agent-cz \
           bkjeholt/mqtt-agent-cz:latest

