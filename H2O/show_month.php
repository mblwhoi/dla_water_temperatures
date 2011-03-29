<?php # Show_month.php
$update_date = "April 21, 2010";
$mon_wanted = $_POST['month'];
$max_year = 2005;

// Make an array variable for the month names
$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June',
   'July', 'August', 'September', 'October', 'November', 'December');

$page_title = "Historic WHOI Pier Water Temperatures for $months[$mon_wanted]";
require ('water_temp_header.php');

// include db_connect script
require_once('../water_temp_db_connect.php');

// get database handle
$db = get_db_handle();


//Make the query
$query1 = "SELECT * FROM h2o_temps WHERE month=$mon_wanted AND year<=$max_year ORDER BY year DESC,date";

//Run the query
$rs1 = $db->executeQuery($query1);

if ($rs1->next()) { // If it ran OK, get the years and display the results
   $result1 = $rs1->getCurrentValuesAsHash();
   
   $query2 = "SELECT year from temp_years ORDER BY year DESC";
   $result2 = $db->executeQuery($query2);
   
   echo '<center><h2>Water temperatures for ' . $months[$mon_wanted] . '</h2></center>';
   // Start the table and make the heading row
   echo '<p><table align="center" cellspacing="2" cellpadding="2" border>
      <tr><td align="Left"><font color="#0F395F" size = "-1"><b>Year</b></font></td>';
   for ($day = 1; $day <=31; $day++){
      echo '<td align="Center"><font size = "-1"><b>' . $day . '</b></font></td>';
      }
   echo '</tr>';
   // write the rest of the table
   while ($result2->next()) {
      $row2 = $result2->getCurrentValuesAsHash();
      echo '<tr><td align="Left"><font color="#0F395F" size="-1"><b>' . $row2['year'] . '</b></font></td>';
      for ($day = 1; $day <= 31; $day++) {
        $rs1->next();
        $row1 = $rs1->getCurrentValuesAsHash();
        echo '<td align = "Center"><font size="-1">';
        if ($row1['temperature'] != NULL) {
             echo $row1['temperature'];
        } else  {
             echo '##';
        }  //end if-else
        echo '</font></td>';
      } // end for loop
      echo '</tr>';
   } //end outer while
   echo '</table></p>';

} else { // If it did not run OK.
     echo '<p> The water temperatures could not be displayed due to a system error.
     We apologize for any inconvenience.</p>';
}
// ask for another month
echo '<hr /><p><font color = "#0F395F"><b>Select another month to display:</b></font><br />';

//begin the html form to select another month
echo '<form action="show_month.php?" method="post">';
echo '<select name="month">';
foreach ($months as $key => $value) {
   echo "<option value=\"$key\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get temps" />
</form>';

require ('water_temp_footer.php');

?>
