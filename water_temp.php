<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"/
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Historic WHOI Pier Seawater Temperatures</title>
</head>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2079517-1";
urchinTracker();
</script> 
<body bgcolor="#FFFFFF" text="#000000" link="#2F588F" vlink="#2F588F" alink="#6B6969">
<center>

<h2>
<font color="#0F395F">Historic Seawater Temperatures from the WHOI Pier</font></h2>

<p>Measurements recorded from the pier of the Woods Hole Oceangraphic Institution, 1893 - 2005</p>

 <div>
  <img src="images/water_temp.gif" align="middle" alt="D.Rogers measuring temp">
  <div style="font-size:small;">
    Dorothy "Dot" Rogers, who measured daily water temperatures at the WHOI pier for more than 38 years.
  </div>
</div>

<hr />
</center>

<h3>View Temperatures Online</h3>

<?php
//begin PHP section

// section to get temperatures for a particular year

// include db_connect script
require_once('water_temp_db_connect.php');

// get database handle
$db = get_db_handle();


echo '<font color="#0F395F"><b>Display temperatures for a particular year:</b></font>';
// get the list of available years
$query = "SELECT year from temp_years ORDER BY year DESC";
$result = $db->executeQuery($query);
// put the results in an array
while ($result->next()) {
     $row = $result->getCurrentValuesAsHash();
     $years_avail[] = $row['year'];
     }

//begin the html form to select a year
echo '<form action="H2O/show_temps.php?" method="post">';
echo '<select name="year">';
foreach ($years_avail as $key => $value) {
   echo "<option value=\"$value\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get temps" />
</form>';

// section to get temperatures for a particular month
// Make an array variable for the month names
$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June',
   'July', 'August', 'September', 'October', 'November', 'December');
echo '<font color = "#0F395F"><b>Display temperatures for a particular month in all years:</b></font>';
//begin the html form to select a month
echo '<form action="H2O/show_month.php?" method="post">';
echo '<select name="month">';
foreach ($months as $key => $value) {
   echo "<option value=\"$key\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get temps" />
</form>';

// section to get statistics
echo '<font color = "#0F395F"><b>Display minimum, maximum and average temperatures for a particular year, month in all years or date in all years:</b></font>';
//begin the html code to select a year, month or date
echo '<table align = "Center" width = "100%" cellspacing="2" cellpadding="2" border><tr>';
// get another year
echo '<td> Select a year: <br />';
//begin the html form to select a year
echo '<form action="H2O/show_yrstat.php?" method="post">';
echo '<select name="year">';
foreach ($years_avail as $key => $value) {
   echo "<option value=\"$value\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get statistics" />
</form>';
echo '</td>';
// begin the form to get a month
echo '<td> Select a month: <br />';
echo '<form action="H2O/show_monstat.php?" method="post">';
echo '<select name="month">';
foreach ($months as $key => $value) {
   echo "<option value=\"$key\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get statistics" />
</form>';
echo '</td>';
// begin the form to get a date
echo '<td>Select a date: <br />';
echo '<form action="H2O/show_datestat.php?" method="post">';
echo '<select name="month">';
foreach ($months as $key => $value) {
   echo "<option value=\"$key\"> $value</option>\n";
}
echo '</select>';
echo '<select name = "date">';
   for ($day = 1; $day <=31; $day++){
    echo "<option value=\"$day\"> $day</option>\n";
     }
echo '</select>
<input type="submit" name="submit" value="Get statistics" />
</form>';
echo '</td>';
echo '</tr></table></p>';

//end of php section
?>

<p>
Units: All recordings presented here are in Fahrenheit.
</p>

<p>
Provenance Information: 

<ul>
  <li>Temperatures for 1893-1894, 1898-1901, and 1903 were compiled from the papers of Vinal N. Edwards, Record Group #370 of the National Archives and Records Administration North East Region in Waltham, Massachusetts.</li>
  <li>Mean monthly temperatures for 1886 to 1956 were compiled from Dean Bumpus's <i>Special Scientific Report - Fisheries #214</i> (1957)</li>
  <li> 1956 to 1997 temperatures were compiled from the observations of Dorothy "Dottie" Rogers (pictured above).</li>
  <li> Temperatures after 1997 were recorded by computer and compiled by WHOI staff.</li>
  <li> Paper records for temperatures recorded from 1945 to 1996 are available in the WHOI Archives</li>
</ul>

<hr />


<h3>Download Temperatures</h3>
Temperatures are available as a spreadsheet:<a href="files/whoi_h2otemps_1893_2005.xls">whoi_h2otemps_1893_2005.xls</a>
<hr />


<p><font color="#0F395F"><b>Further information:</font></b><br />
<ul>
<li><a href="uricomp.html">"A One Hundred and Seventeen Year Coastal Water Temperature Record From Woods Hole, Massachusetts"</a> a compilation of Woods Hole water temperature data by S. Nixon and S. Granger of URI.  This article describes a compilation of Woods Hole water temperatures from 1886 to 2002, including temperatures from the WHOI archives.  This article provides more detailed information about collection methods and provides an accompanying water temperatures spreadsheet.</li>

<li><a href="http://tidesandcurrents.noaa.gov">NOAA Tides and Currents Online</a>: NOAA provides access to both historical and current Woods Hole water temperatures.</li>

<li>Contact the <a href="mailto:dla@whoi.edu">Data Library &amp; Archives</a></li>
</ul>
</p>
<hr />


<p><a href="http://dla.whoi.edu/dla">WHOI Data Library and Archives Home Page</a><br/>

<p><a href="http://www.mblwhoilibrary.org">MBLWHOI Library Home Page</a><br />
</p>
</body>
</html>
