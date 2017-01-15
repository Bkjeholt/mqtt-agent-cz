/************************************************************************
 Product    : Home information and control
 Date       : 2016-10-25
 Copyright  : Copyright (C) 2016 Kjeholt Engineering. All rights reserved.
 Contact    : dev@kjeholt.se
 Url        : http://www-dev.kjeholt.se
 Licence    : ---
 -------------------------------------------------------------------------
 File       : MqttAgentCZ/testport_cz.js
 Version    : 0.1.2
 Author     : Bjorn Kjeholt
 *************************************************************************/

var SerialPort = require('serialport');
 
var port = new SerialPort('/dev/ttyUSB0', {
                              baudRate: parseInt(process.env.SERIALPORT_BAUD_RATE),
                              dataBits: parseInt(process.env.SERIALPORT_DATA_BITS),
                              stopBits: parseInt(process.env.SERIALPORT_STOP_BITS),
                              parity: 'none',
                              parser: SerialPort.parsers.readline('\n')
                          });


port.on('data', function(data) {
          var recDataArray = [];
  
          recDataArray = data.replace(/\s+/g, " ").split(" ");
  
          console.log("Received data:",recDataArray);
//          console.log('Received data: <<' + data + '>>');  
});

var cnt= 0;

setInterval(function() {
    console.log("Time count: " + cnt + "sec.");
    cnt = cnt + 10;
},10000);

