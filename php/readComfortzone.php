<?php
//header("Cache-Control: no-cache, must-revalidate");
ini_set('default_charset','UTF-8');   // manage swedish characters

include_once "/home/per/Script/CZ50/msql_pwd.php";
include_once 'helpers/analyze.php';
include_once 'helpers/send.php';
include_once 'helpers/error.php';

$ttyDev = "/dev/ttyS0";

//------------------------------------------------------------------------------------
// Function that returns a single value from a given query.
// The value is taken from the first row returned by the query and given by the first
// column {row[0]}.
//
// Re-write function...
// Improvements:
//              1. create dynamic function that takes the field(e.g G6) in the table as
//                 input and returns the value.  Use mysql_fetch_array() that will take
//                 an field argument, for example 'G6'.
//              2. The value might not be written for the latest created timestamp when
//                 this function is called! Fix!
//------------------------------------------------------------------------------------

function msql_value($query) {

$p_row = mysql_query( $query ) or die ("SQL fault in Query: " . $query . "\n");

if (mysql_num_rows($p_row) > 0) {
     $row = mysql_fetch_row($p_row);

//     if ($row[0] > 0) {
//       if ($row[0] == 0) {
//          sleep(1);
//       }
//       if ($row[0] == 0) {
//         echo "Error code : empty column in table\n";
//       }
//     }
//     else {
//       echo "Error code : emtpy row in table\n";
//     }
     return $row[0];
}
else {
   echo "Error code : 1\n";
}
}

//------------------------------------------------------------------------------------
// Function for reading current timestamp from mysql server
//------------------------------------------------------------------------------------

function msql_get_current_timestamp() {

$query = "SELECT NOW()";
$currentTimeStamp = msql_value($query);

return $currentTimeStamp;

}




//------------------------------------------------------------------------------------ 
// storeInDatabase
//
// Information below from varepumpsforum:
//
// 1 Tid (sedan omstart)
// 2 Innetemp borvarde
// 3 VV temp borvarde
// 4 Innetemp uppmatt
// 5 Varmvattentank temp uppmatt
// 6 Avluft temp uppmatt
// 7 Retur temp uppmatt
// 8 Varmekallor (tsv testmeny R)
// 9 digitala ingangar (motsv testmeny I)
// 10 Aktuell frekv hz kompressor
// 11 Aktuell flakt hast %
// 12 ? (positivt fladdrande varde)
// 13 ? (alltid 1)
// 14 Konstant ? (ranas om om böoemp inne änandras)
// 15 I-del luftloop (0.01K)
// 16 I-del golvloop (W)
// 17 Framlednings temp berakna av CZ (degC)
// 18 kW/W (displayvardet)
// 19 ? Intressant varde 
// 20 ? Intressant varde 
// 21 ? Intressant varde 
// 22 Aktuell tillatn maxferkvens (tex 50hz vid vv)
// 23 Begar effekt golvtemp/radiator-loop (W)
// 24 Aktuell kW eltillskott 
// 25 Rrknae (startar vid avfrostning, svallis varningen?)
// 26 Konstant M
// 27 Konstant M1 
// 28 Konstant M2
// 29 Konstant ?
// 30 Konstant ?
// 31 Konstant ?
// 32 Konstant Heat cond Lir 1500 W/K (konfig meny)
// 33 ? (alltid 0)
// 34 P-del luftloop = a2x[Innetemp(uppmat)-Innetemp(böorx100 (0.01K)
// 35 P-del golvloop = |a1|*(Retur(bo)-Retur(uppmäattx100 (0.01K)
// 36 ? (alltid 0)
// 37 ? (alltid 0)
// 38 Konstant ?
// 39 ? (alltid 0)
// 40 Raknae (mintid komp av)
// 41 Raknare mintid komp av/på)
// 42 Raknare(mintid komp på)
// 43 ? (alltid 0)
// 44 ? (alltid 0)
// 
//------------------------------------------------------------------------------------ 

function storeInDatabase($vpstring) {


  // cz011 = Offset F2 Varmvatten?

  $arr = array(
    'czUptime',  
    'czTempRoom_SP',   
    'czTempTank_SP',   
    'czTempRoom',   
    'czTempTank',   
    'czTempEvap',   
    'czTempReturnPipe',   
    'czHeatSources',   
    'czDigSensors',   
    'czCompFreq',
    'czFanVoltPerc',  
    'cz011',
    'cz012',   
    'cz013',   
    'cz014',   
    'cz015',      
    'czTempSupplyPipeEst',   
    'czPowerDisplay',   
    'cz018',   
    'cz019',    
    'cz020',   
    'czCompFreqMaxAllowed',   
    'czPowerRequested',   
    'czPowerAuxHeater',   
    'cz024',   
    'cz025',   
    'cz026',   
    'cz027',   
    'cz028',   
    'cz029',   
    'cz030',   
    'cz031',    
    'cz032',   
    'cz033',   
    'cz034',   
    'cz035',   
    'cz036',   
    'cz037',   
    'cz038',   
    'cz039',   
    'cz040',   
    'cz041',   
    'cz042',   
    'cz043');

  // 1. Split the string of data into an array of data based on a '_' delimiter.
  // 2. Combine the new array into the array 'arr' with named indexes.

  $arr = array_combine($arr, split('_',$vpstring)); 

  $czHeatSources = $arr["czHeatSources"];

  $currentTimeStamp = msql_get_current_timestamp();

  $query = "INSERT INTO SensorData " . 
    "(" .
    "TimeStamp," . 
    "Uptime," . 
    "TempRoom," .
    "TempTank," .
    "TempEvap," .
    "TempReturnPipe," .
    "CompressorOperation," .
    "ValvePosition," .
    "AuxHeater1," . 
    "AuxHeater2," . 
    "AuxHeater3," .
    "CompFreq," .
    "TempSupplyPipeEst," .
    "PowerDisplay," .
    "PowerRequested," .
    "PowerAuxHeater) " .

    "VALUES (" . "'" .
    $currentTimeStamp . "' , '" .
    $arr["czUptime"] . "' , '" .
    $arr["czTempRoom"] . "' , '" .
    $arr["czTempTank"] . "' , '" .
    $arr["czTempEvap"] . "' , '" .
    $arr["czTempReturnPipe"] . "' , '" .
    $czHeatSources[0] . "' , '" .
    $czHeatSources[1] . "' , '" .
    $czHeatSources[2] . "' , '" .
    $czHeatSources[3] . "' , '" .
    $czHeatSources[4] . "' , '" .
    $arr["czCompFreq"] . "' , '" .
    $arr["czTempSupplyPipeEst"] . "' , '" .
    $arr["czPowerDisplay"] . "' , '" .
    $arr["czPowerRequested"] . "' , '" .
    $arr["czPowerAuxHeater"] . "' " .
    ")";

  $result = mysql_query( $query ) or die ("SQL fault in Query: " . $query);


  $czDigSensors = $arr["czDigSensors"];
  $A1 = $czDigSensors[0];
  $A2 = $czDigSensors[1]; // Normal = 1, alarm = 0
  $A4 = $czDigSensors[3];
  $A5 = $czDigSensors[4]; // Normal = 1, alarm = 0
  settype($A1, "bool"); 
  settype($A2, "bool"); 
  settype($A4, "bool"); 
  settype($A5, "bool"); 

  if($A1 || !$A2 || $A4 || !$A5) {
  
    $query = "INSERT INTO Alarm " . 
      "(" .
      "TimeStamp," . 
      "Inverter," .
      "HighPreasure," .
      "Freezer," .
      "Filter) " .

      "VALUES (" . "'" .
      $currentTimeStamp . "' , '" .
      $czDigSensors[0] . "' , '" .
      !$czDigSensors[1] . "' , '" .
      $czDigSensors[3] . "' , '" .
      !$czDigSensors[4] . "' " .
      ")";

    $result = mysql_query( $query ) or die ("SQL fault in Query: " . $query);

  }

  // Check logged parameter value has changed since last logging, if so then
  // store all parameters.

    $query = "INSERT INTO Parameter " . 
      "(" .
      "TimeStamp," . 
      "TempRoom," .
      "TempTank," .
      "CompFreqMax," .
      "FanVoltPerc) " .

      "VALUES (" . "'" .
      $currentTimeStamp . "' , '" .
      $arr["czTempRoom_SP"] . "' , '" .
      $arr["czTempTank_SP"] . "' , '" .
      $arr["czCompFreqMaxAllowed"] . "' , '" .
      $arr["czFanVoltPerc"] . "' " .
      ")";

    $result = mysql_query( $query ) or die ("SQL fault in Query: " . $query);

  // =====================================
  // store data stream/array in a logfile:
  // =====================================

  $logfile = "/var/www/tempWebPages/CZlatestLogEntry.txt";

  $currentTimeStamp = msql_get_current_timestamp();

  if (!$fh = fopen($logfile, 'w')) {
    echo "Cannot open file ($logfile)\n";
    exit;
  }

  if (fwrite($fh, "$currentTimeStamp\n\n") === FALSE) { 
    echo "Cannot write to file ($logfile)\n";
    exit;
  }  

  $dg = chr(176);  //degree character

  $row1 = "R" . $arr["czHeatSources"] . " " . "I" . $arr["czDigSensors"] . " " . "P " . $arr["czCompFreq"] . "\n";
  // $row2 = "A____________" . " F" . $arr["czFan_SP"] . "\n";
  $row3 = "A " . number_format($arr["czTempRoom"],1) . "$dg" . "C  " . "C " . number_format($arr["czTempEvap"],1) . "$dg" . "C" .  "\n";
  $row4 = "B " . number_format($arr["czTempTank"],1) . "$dg" . "C  " . "D " . number_format($arr["czTempReturnPipe"],1) . "$dg" . "C"  . "\n";
  $row = $row1 . $row3 . $row4 . "\n";    


  $R1 = $czHeatSources[0];
  $R2 = $czHeatSources[1];  
  $R3 = $czHeatSources[2];
  $R4 = $czHeatSources[3];
  $R5 = $czHeatSources[4];
  settype($R1, "bool"); 
  settype($R2, "bool"); 
  settype($R3, "bool"); 
  settype($R4, "bool"); 
  settype($R5, "bool"); 



if($R1 || $R3 || $R4 || $R5) {

  if($R2) { // VV-prod
    $r = "Producerar VV:\n";
  }
  else {
    $r = "Producerar radiatorkrets:\n";
  }
  if($R1) {
    $r = $r . " -> Kompressor till (" . $arr["czCompFreq"] . "Hz, ~" . $arr["czPowerDisplay"] . "W)" . "\n";
  }

  if($R3) {
    $r = $r . " -> Elpatron 3 till (2000kW)" . "\n";
  }
  if($R4) {
    $r = $r . " -> Elpatron 2 till (2000kW)" . "\n";
  }
  if($R5) {
    $r = $r . " -> Elpatron 1 till (2000kW)" . "\n";
  }
  $row = $r . "\n" . $row . "\n\n\n\n\n";
}


  if (fwrite($fh, $row) === FALSE) { 
    echo "Cannot write to file ($logfile)\n";
    exit;
  }  



  foreach($arr as $k => $v) {
    if (fwrite($fh, "$k = \t\t$v\n") === FALSE) { 
      echo "Cannot write to file ($logfile)\n";
      exit;
    }  
  }

  fclose($fh);

}



//------------------------------------------------------------------------------------
// logError
//
//------------------------------------------------------------------------------------ 
function logError($errorMsg) {

  // echo "==> logError()\n"; // *logprintout*

  $errorLog = "/var/www/php/CZ50/errorLog.txt";

  $currentTimeStamp = msql_get_current_timestamp();
  $errorMsg = "\n\n\n" . $currentTimeStamp . ":\n" . $errorMsg . "\n\n\n";

  if (!$fh = fopen($errorLog, 'a')) {
    echo "Cannot open file ($filename)\n";
    exit;
  }

  if (fwrite($fh, $errorMsg) === FALSE) {
    echo "Cannot write to file ($filename)\n";
    exit;
  }

  fclose($fh);
}


//------------------------------------------------------------------------------------
// logData
// Temp solution to write all data to file for easier access of latest log data...
//------------------------------------------------------------------------------------ 
function logData($xmlMsg) {

  // echo "==> logData()\n"; // *logprintout*

  storeInDatabase($vpstring);

  $dataLog = "/var/www/tempWebPages/CZdataLog.txt";
  $currentTimeStamp = msql_get_current_timestamp();
  $vpstring = $currentTimeStamp . "_" . $vpstring . "\n\n";  

  if (!$fh = fopen($dataLog, 'a')) {
    echo "Cannot open file ($dataLog)\n";
    exit;
  }

  if (fwrite($fh, $vpstring) === FALSE) {
    echo "Cannot write to file ($dataLog)\n";
    exit;
  }
  fclose($fh);




}


//------------------------------------------------------------------------------------
// Function for login into the database
// Database specific information is stated in file msql_pwd.php
//------------------------------------------------------------------------------------

function msql_login($mysql_path,$mysql_db,$mysql_user,$mysql_password) {

  // echo "==> msql_login()\n"; // *logprintout*

         $db=mysql_connect($mysql_path,
                          $mysql_user,
                          $mysql_password)
            or die ("Unable to connect to MySQL server");

            mysql_select_db($mysql_db, $db)
           or die ("Unable to connect to database");
}






//------------------------------------------------------------------------------------
// MAIN procedure
//
// stty -F /dev/ttyS0 ispeed 38400 cs8 -ixon -icanon time 100 min 10
//
//------------------------------------------------------------------------------------ 

// echo "DB = " . Const_MysqlDB;

msql_login(Const_MysqlPath, 
            Const_MysqlDB, 
            Const_MysqlUser, 
            Const_MysqlPassword);


// Check the following definition for the  ttyS0 device!
// Setup the ttyS0 device:
//
// How to handle a failure for the system call?
//

// Does not work when this file is called from init.d shell!
// Moved the below statement to the shell script to initiate the tty device.
//$cmd = "stty -F /dev/ttyS0 ispeed 38400 cs8 -ixon -icanon time 100 min 10";
//$result = system($cmd);

  // echo "Open ttyS0\n"; // *logprintout*

// Open device to read from heating system
$fh  = fopen($ttyDev, 'r') or die("can't open file\n");


  // echo "Start while loop\n"; // *logprintout*

// read ttyS0 device character by character

$analyzeObj = new  VPanalys();
$sendObj = new VPSendXml();

while (true) {

      $c = fgetc($fh);
      
      $analyzeObj->analyze($c);
} 

?>
