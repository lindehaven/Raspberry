<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="refresh" content="300">
  <meta name="description" content="Raspberry Pi Temperature">
  <link rel="stylesheet" href="fonts/font.css">
  <style type="text/css">
    @media screen and (max-width: 320px) { @viewport { width: 320px; } }
    @media screen and (min-width: 768px) and (max-width: 959px) { @viewport { width: 768px; } }
    body {width: 98%; background-color: #ddd; color: #444; font-family: 'LCDBOLD';}
    table {width: 100%; border: 1px solid #333; padding: 8px 8px 8px 8px}
    .head {font-size: 300%; width: 90%; text-align: center;}
    .sen {font-size: 300%; width: 25%; text-align: right;}
    .val {font-size: 800%; width: 40%; text-align: center;}
    .per {font-size: 300%; width: 25%; text-align: left;}
    .low {font-size: 500%; width: 25%; text-align: right;}
    .avg {font-size: 500%; width: 40%; text-align: center;}
    .hig {font-size: 500%; width: 25%; text-align: left;}
    .foot {font-size: 150%; width: 90%; text-align: center; font-family: monospace;}
    .cel {font-size: 80%; font-family: monospace}
  </style>
  <title>Temperature</title>
</head>
<body>
<div class="center">

<table><tbody>
<tr class='head'><td>
<?php echo date('Y-m-d H:i:s'); ?>
</td></tr>
</tbody></table>

<?php
define("DECIMALS", 1);
$sensor_array = array("28-041780f40cff"=>"TEMP", "99-999999999999"=>"TEST");
$servername = "localhost";
$username = "webusername";
$password = "webpassword";
$dbname = "web";

$day = $_GET["d"];
$month = $_GET["m"];
$year = $_GET["y"];
if (!empty($day)) {
  $sqldate = "sampled_at BETWEEN '" . $day . " 00:00:00' AND '" . $day . " 23:59:59'";
  $period = $day;
} else if (!empty($month)) {
  $sqldate = "sampled_at BETWEEN '" . $month . "-01 00:00:00' AND '" . $month . "-31 23:59:59'";
  $period = $month;
} else if (!empty($year)) {
  $sqldate = "sampled_at BETWEEN '" . $year . "-01-01 00:00:00' AND '" . $year . "-12-31 23:59:59'";
  $period = $year;
} else {
  $sqldate = "DATE(`sampled_at`) = CURDATE();";
  $period = date('Y-m-d');
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo "<table><tbody><tr class='val'><td>N/A</td></tr></tbody></table>";
  die();
}

foreach ($sensor_array as $sensor_id=>$sensor_name) {
  $value = "N/A";
  $lowest = "N/A";
  $average = "N/A";
  $highest = "N/A";
  $sql = "SELECT sampled_at, sensor_val FROM temperature WHERE sensor_id = '" . $sensor_id . "' AND " . $sqldate;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $sum = 0.00;
    $samples = 0;
    $lowest = 9999.99;
    $highest = -9999.99;

    while ($row = $result->fetch_assoc()) {
      $at = $row["sampled_at"];
      $value = $row["sensor_val"];
      if ($value > -273.16) {
        $sum = $sum + $value;
        $samples = $samples + 1;
        if ($value < $lowest) {
          $lowest = $value;
        }
        if ($value > $highest) {
          $highest = $value;
        }
        $value = number_format($value, DECIMALS);
        $lowest = number_format($lowest, DECIMALS);
        $average = number_format($sum / $samples, DECIMALS);
        $highest = number_format($highest, DECIMALS);
      }
    }
  }
  echo "<table><tbody>";
  echo "<tr>";
  echo "<td class='sen'>" . $sensor_name . "</td>";
  echo "<td class='val'>" . $value . "<sup class='cel'>&deg;C</sup></td>";
  echo "<td class='per'>" . $period . "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class='low'>" . $lowest . "<sup class='cel'>&deg;C</sup></td>";
  echo "<td class='avg'>" . $average . "<sup class='cel'>&deg;C</sup></td>";
  echo "<td class='hig'>" . $highest . "<sup class='cel'>&deg;C</sup></td>";
  echo "</tr>";
  echo "</tbody></table>";
}

$conn->close();

$cpu_temp = exec("cat /sys/class/thermal/thermal_zone0/temp", $unused, $ret_val);
if ($ret_val != 0)
   $cpu_temp = "N/A";
else
   $cpu_temp = number_format($cpu_temp/1000, DECIMALS);
echo "<table><tbody>";
echo "<tr>";
echo "<td class='sen'>CPU</td>";
echo "<td class='val'>" . $cpu_temp . "<sup class='cel'>&deg;C</sup></td>";
echo "<td class='per'></td>";
echo "</tbody></table>";
?>

<table><tbody>
<tr class='foot'><td>
By Lars Lindehaven 2018-04-04. Raspberry Pi Zero W.
</td></tr>
</tbody></table>

</div>
</body>
</html>
