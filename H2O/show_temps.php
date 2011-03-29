<?php # Show_temps.php
$update_date = "April 21, 2010";
$yr_wanted = $_POST['year'];
$page_title = "Historic WHOI Pier Water Temperatures for $yr_wanted";

// Make an array variable for the month names
$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June',
   'July', 'August', 'September', 'October', 'November', 'December');

require ('water_temp_header.php');

// include db_connect script
require_once('../water_temp_db_connect.php');

// get database handle
$db = get_db_handle();


//Make the query
$query = "SELECT * FROM h2o_temps WHERE year=$yr_wanted ORDER BY month,date";
//Run the query
$rs = $db->executeQuery($query);
if ($rs->next()) { // If it ran OK, display the results
   echo '<center><h2>Water temperatures for ' . $yr_wanted . '</h2></center>';
   // Start the table and make the heading row
   echo '<p><table align="center" cellspacing="2" cellpadding="2" border>
      <tr><td align="Left"><font color= "#0F395F" size = "-1"><b>Month</b></font></td>';
   for ($day = 1; $day <=31; $day++){
      echo '<td align="Center"><font size = "-1"><b>' . $day . '</b></font></td>';
      }
   echo '</tr>';
   // write the rest of the table
   for ($mon = 1; $mon <=12; $mon++) {
      echo '<tr><td align="Left"><font color= "#0F395F" size="-1"><b>' . $months[$mon] . '</b></font></td>';
      for ($day = 1; $day <=31; $day++) {
          $rs->next();
          $row =  $rs->getCurrentValuesAsHash();
          echo '<td align = "Center"><font size="-1">';
          if ($row['temperature'] != NULL) {
               echo $row['temperature'];
          } else  {
               echo '##';
          }
          echo '</font></td>';
      }
      echo '</tr>';
   }
   echo '</table></p>';
} else { // If it did not run OK.
     echo '<p> The water temperatures could not be displayed due to a system error.
     We apologize for any inconvenience.</p>';
}
// ask for another year
echo '<hr /><p><font color = "#0F395F"><b>Select another year to display:</b></font><br />';

// get the list of available years
$query = "SELECT year from temp_years ORDER BY year DESC";
$rs = $db->executeQuery($query);
// put the results in an array
while ($rs->next()) {
   $row =  $rs->getCurrentValuesAsHash();
     $years_avail[] = $row['year']; }
//begin the html form to select another year
echo '<form action="show_temps.php?" method="post">';
echo '<select name="year">';
foreach ($years_avail as $key => $value) {
   echo "<option value=\"$value\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get temps" />
</form>';


// Close the database connection.
require ('water_temp_footer.php');

?>
