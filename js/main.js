/************************************************************************
 Product    : Home information and control
 Date       : 2016-10-25
 Copyright  : Copyright (C) 2016 Kjeholt Engineering. All rights reserved.
 Contact    : dev@kjeholt.se
 Url        : http://www-dev.kjeholt.se
 Licence    : ---
 -------------------------------------------------------------------------
 File       : MqttAgentCZ/main.js
 Version    : 0.1.0
 Author     : Bjorn Kjeholt
 *************************************************************************/

var agent = require('./Classes/agentBody');

var agentObj = agent.create_AgentBody({ 
                                    agent: {
                                            name: process.env.npm_package_name,
                                            rev:  process.env.npm_package_version },
                                    mqtt: {
                                            ip_addr: process.env.MQTT_IP_ADDR,   // "192.168.1.10",
                                            port_no: process.env.MQTT_PORT_NO,   // "1883",
                                            user:    process.env.MQTT_USER,      //"hic_nw",
                                            passw:   process.env.MQTT_PASSWORD,  //"RtG75df-4Ge",
                                            connected: false,
                                            link: { 
                                                    status: 'down',
                                                    latest_status_time: (Math.floor((new Date())/1000)),
                                                    timeout: 120 }, // seconds
                                            subscriptions: [
                                                    "data/set/" + process.env.npm_package_name + "/#"
                                            ]
                                          },
                                    serialport: {
                                            portaddr: '/dev/ttyAgentCZ',
                                            baudrate: parseInt(process.env.SERIALPORT_BAUD_RATE),
                                            databits: parseInt(process.env.SERIALPORT_DATA_BITS),
                                            stopbits: parseInt(process.env.SERIALPORT_STOP_BITS),
                                            parity:   'none'
                                          },
                                    node: {
                                            scan_node_data: 30000,
                                            scan_new_nodes: 300000 }
                                  });
var cnt= 0;

setInterval(function() {
    console.log("Status @ " + cnt + "sec. Mqtt link connected:" + agentObj.ci.mqtt.connected);
    cnt = cnt + 10;
},10000);
//abhObj.setup();

