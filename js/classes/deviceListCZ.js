/************************************************************************
 Product    : Home information and control
 Date       : 2016-10-27
 Copyright  : Copyright (C) 2016 Kjeholt Engineering. All rights reserved.
 Contact    : dev@kjeholt.se
 Url        : http://www-dev.kjeholt.se
 Licence    : MIT
 ---------------------------------------------------------
 File       : mqtt-agent-cz/deviceListCZ.js
 Version    : 0.1.0
 Author     : Bjorn Kjeholt
 ---------------------------------------------------------
414:38:06 21.0 50.0 2.173E+01 4.656E+01 -6.462E+00 5.206E+01 11 00001001 60.0  41    51 5.624E+02 0.000E-00 0.000E-00 5.630E+01 438423.99 5.800E+00 4.10   60 4384    0    0 3.000E+05 3.200E+07 4.000E+07-4.687E+02-3.750E+02-7.812E-02 1.500E+03-5.624E+02 0.000E-00 0.000E-00 0.00 0.00 0.000E-00    0    0    0    0    0    0

 *************************************************************************/

exports.deviceList = [
            {   id: 0,
		name: 'czUptime',
                datatype: 'float',
		devicetype: 'ackumulated',
		variables: [] },
            {   id: 1,
		name: 'czTemp',
                datatype: 'float',
                devicetype: 'dynamic',
		variables: 	[]},
            {   id: 2,
                name: 'czTempRoom_SP',
                datatype: 'float',
                devicetype: 'dynamic',
                variables: []},
            {   id: 3,
                name: 'czTempTank_SP',
                datatype: 'float',
                devicetype: 'dynamic',
                variables: []},
            {   id: 4,
                name: 'czTempRoom',
                datatype: 'float',
                devicetype: 'dynamic',
                variables: []},
            {   id: 5,
                name: 'czTempTank',
                datatype: 'float',
                devicetype: 'dynamic',
                variables: []},
                            { id: 4,
                              name: 'czTempEvap',
                              datatype: 	'bool',
                              devicetype: 'semistatic' },
                            { id: 5,
                              name: 'czTempReturnPipe',
                              datatype: 	'bool',
                              devicetype: 'semistatic' },
                            { id: 6,
                              name: 			'czHeatSources',
                              datatype: 	'bool',
                              devicetype: 'semistatic' },
                            { id: 7,
                              name: 			'czDigSensors',
                              datatype: 	'bool',
                              devicetype: 'semistatic' }
			] },
        {   id:					2,
            name: 			'czCompFreq',
            datatype: 	'int',
            devicetype: 'dynamic',
            variables: 	[] },
	{   id:					3,
            name: 			'czFanVoltPerc',
            datatype: 	'float',
            devicetype: 'dynamic',
            variables: 	[] },
										 ];

/*
    	<dev id='12' name='cz011' det='semistatic' dat='bool'/>
    	<dev id='13' name='cz012' det='semistatic' dat='bool'/>   
    	<dev id='14' name='cz013' det='semistatic' dat='bool'/>   
    	<dev id='15' name='cz014' det='semistatic' dat='bool'/>   
    	<dev id='16' name='cz015' det='semistatic' dat='bool'/>      
    	<dev id='17' name='czTempSupplyPipeEst' det='semistatic' dat='bool'/>   
    	<dev id='18' name='czPowerDisplay' det='semistatic' dat='bool'/>   
    	<dev id='19' name='cz018' det='semistatic' dat='bool'/>   
    	<dev id='20' name='cz019' det='semistatic' dat='bool'/>    
    	<dev id='21' name='cz020' det='semistatic' dat='bool'/>   
    	<dev id='22' name='czCompFreqMaxAllowed' det='semistatic' dat='bool'/>   
    	<dev id='23' name='czPowerRequested' det='semistatic' dat='bool'/>   
    	<dev id='24' name='czPowerAuxHeater' det='semistatic' dat='bool'/>   
    	<dev id='25' name='cz024' det='semistatic' dat='bool'/>   
    	<dev id='26' name='cz025' det='semistatic' dat='bool'/>   
    	<dev id='27' name='cz026' det='semistatic' dat='bool'/>   
    	<dev id='28' name='cz027' det='semistatic' dat='bool'/>   
    	<dev id='29' name='cz028' det='semistatic' dat='bool'/>   
    	<dev id='30' name='cz029' det='semistatic' dat='bool'/>   
    	<dev id='31' name='cz030' det='semistatic' dat='bool'/>   
    	<dev id='32' name='cz031' det='semistatic' dat='bool'/>    
    	<dev id='33' name='cz032' det='semistatic' dat='bool'/>   
    	<dev id='34' name='cz033' det='semistatic' dat='bool'/>   
    	<dev id='35' name='cz034' det='semistatic' dat='bool'/>   
    	<dev id='36' name='cz035' det='semistatic' dat='bool'/>   
    	<dev id='37' name='cz036' det='semistatic' dat='bool'/>   
    	<dev id='38' name='cz037' det='semistatic' dat='bool'/>   
    	<dev id='39' name='cz038' det='semistatic' dat='bool'/>   
    	<dev id='40' name='cz039' det='semistatic' dat='bool'/>   
    	<dev id='41' name='cz040' det='semistatic' dat='bool'/>   
    	<dev id='42' name='cz041' det='semistatic' dat='bool'/>   
    	<dev id='43' name='cz042' det='semistatic' dat='bool'/>   
    	<dev id='44' name='cz043' det='semistatic' dat='bool'/>
	</devinfo>
</conf>
*/
