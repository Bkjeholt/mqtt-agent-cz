/************************************************************************
 Product    : Home information and control
 Date       : 2016-10-27
 Copyright  : Copyright (C) 2016 Kjeholt Engineering. All rights reserved.
 Contact    : dev@kjeholt.se
 Url        : http://www-dev.kjeholt.se
 Licence    : MIT
 ---------------------------------------------------------
 File       : mqtt-agent-cz/nodeCZ.js
 Version    : 0.1.0
 Author     : Bjorn Kjeholt
 ---------------------------------------------------------
 Data struct: [
		 {name: ”ovpn-test-cert-34”,
		  devices: [
			{ name: ”e-post”,
			  dat: ”text”,
			  det: ”semistatic”,
			  value: ”” },
			{ name: ”certificate”,
			  dat: ”text”,
			  det: ”semistatic”,
			  value: ”” }
			    ]}
	       ]
 Rec. string:
 414:38:06 21.0 50.0 2.173E+01 4.656E+01-6.462E+00 5.206E+011100001001 60.0  41    51 5.624E+02 0.000E-00 0.000E-00 5.630E+01 438423.99 5.800E+00 4.10   60 4384    0    0 3.000E+05 3.200E+07 4.000E+07-4.687E+02-3.750E+02-7.812E-02 1.500E+03-5.624E+02 0.000E-00 0.000E-00 0.00 0.00 0.000E-00    0    0    0    0    0    0

 *************************************************************************/

var SerialPort = require('serialport');

var nodeCZ = function(ci) {
    var self = this;
    
    var serialDataInfo = { devInfoSent: 0,
                           faultyLine: 1,
                           receivedString: "" };
    
    this.sPort = null; 
	
    
    this.configInfo = ci;
		
//    console.log("ConfigInfo", ci);

    
    this.deviceInfoList = [
        {   id: 0,
            name: 'czUpTime',
            dat: 'int',
            det: 'dynamic',
            variables: [] },
        {   id: 1,
            name: 'czTempTank',
            dat: 'float',
            det: 'dynamic',
            variables: [] },
        {   id: 7,
            name: 'czBoolVector1',
            variables: [
                        {   id: 0,
                            name: 'czTempTank',
                            dat: 'bool',
                            det: 'semistatic' }
                       ] }
        
    ];

    this.getDeviceInfo = function (callback) {
        var deviceIndex = 0;
        var variableIndex = 0;
        
        for (deviceIndex = 0; 
             deviceIndex < self.deviceInfoList.length; 
             deviceIndex = deviceIndex + 1) {
            
            if (self.deviceInfoList[deviceIndex].variables.length > 0) {
                for (variableIndex = 0; 
                     variableIndex < self.deviceInfoList[deviceIndex].variables.length; 
                     variableIndex = variableIndex + 1) {
             
                    callback(null, {node: 'cz-serial-data',
                                    device: self.deviceInfoList[deviceIndex].name,
                                    variable: self.deviceInfoList[deviceIndex].variables[variableIndex].name},
                                   {datatype: self.deviceInfoList[deviceIndex].variables[variableIndex].dat,
                                    devicetype: self.deviceInfoList[deviceIndex].variables[variableIndex].det });
                }
            } else {
                callback(null, {node: 'cz-serial-data',
                                device: self.deviceInfoList[deviceIndex].name},
                               {datatype: self.deviceInfoList[deviceIndex].variables[variableIndex].dat,
                                devicetype: self.deviceInfoList[deviceIndex].variables[variableIndex].det });
            }
        }
    };
	
    var receiveData = function(dataByte) {
        switch(dataByte[0]) {
            case 
        }
        if (serialDataInfo.faulyLine !== 1) {
            
        }
        
    };
    
    (function setup(ci) {
        var baudRateInt = parseInt(self.configInfo.serialport.baudrate) * 1;
        var dataBitsInt = parseInt(self.configInfo.serialport.databits) * 1;
        var stopBitsInt = parseInt(self.configInfo.serialport.stopbits) * 1;
        
        self.sPort = new SerialPort('/dev/tty-agent-cz', {
                              baudRate: baudRateInt,
                              dataBits: dataBitsInt,
                              stopBits: stopBitsInt,
                              parity: 'none',
                              parser: SerialPort.parsers.byteLength(1)
                        });

        self.sPort.on('data', function(data) {
                            console.log('Received data: <<' + data + '>>');
                        });
		})(self.configInfo);	
};


exports.create_node = function (ci) {
	  return new nodeCZ(ci);
};