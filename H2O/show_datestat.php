<?php # Show_datestat.php
$update_date = "April 21, 2010";
$mon_wanted = $_POST['month'];
$date_wanted = $_POST['date'];

// Make an array variable for the month names
$months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June',
   'July', 'August', 'September', 'October', 'November', 'December');
$page_title = "Historic WHOI Pier Water Temperature Statistics for $months[$mon_wanted] $date_wanted";
require ('water_temp_header.php');

// include db_connect script
require_once('../water_temp_db_connect.php');

// get database handle
$db = get_db_handle();


//do the first query to get stats
$query1 = "SELECT min(temperature) AS minimum, max(temperature) AS maximum, avg(temperature) AS average FROM h2o_temps WHERE month=$mon_wanted and date=$date_wanted AND temperature != 'NULL'";

//Run the query
$rs1 = $db->executeQuery($query1);
if ($rs1->next()) { // If it ran OK, get the dates for min and display
    $result1 = $rs1->getCurrentValuesAsHash();
    echo '<center><h2>Water Temperature Statistics for ' . $months[$mon_wanted] . ' ' . $date_wanted . '</h2></center>';
    $minimum = $result1['minimum'];
    
    $query2 = "SELECT year FROM h2o_temps WHERE month = $mon_wanted AND date = $date_wanted AND temperature = $minimum ORDER BY year";
    $result2 = $db->executeQuery($query2);
    
    echo '<hr> <b>The lowest temperature on ' . $months[$mon_wanted] . ' ' . $date_wanted . ' was ' . $result1['minimum']
         . ' degrees. It occured in the following year(s): </b><ul>';
    while ($result2->next()) {
        $row = $result2->getCurrentValuesAsHash();
        echo '<li>' . $row['year']. '</li>';
    }
    echo '</ul>';
    $maximum = $result1['maximum'];
    
    $query3 = "SELECT year FROM h2o_temps WHERE month = $mon_wanted AND date = $date_wanted AND temperature = $maximum ORDER BY year";
    $result3 = $db->executeQuery($query3);
    
    
    echo '<hr> <b>The highest temperature on ' . $months[$mon_wanted] . ' ' . $date_wanted . ' was ' . $result1['maximum']
          . ' degrees. It occured in the following year(s): </b><ul>';
    while ($result3->next()) {
        $row = $result3->getCurrentValuesAsHash();
        echo '<li>' . $row['year'] . '</li>';
   }
    echo '</ul>';
    echo '<hr> <b>The average temperature on ' . $months[$mon_wanted] . ' ' . $date_wanted . ' was ' . sprintf("%.1f", $result1['average']) . ' degrees.</b>';

} else { // If original query did not run OK.
     echo '<p> The temperature statistics could not be displayed due to a system error.
     We apologize for any inconvenience.</p>';
} // end the else
//ask for another round of statistics
echo '<hr /><p><font color = "#0F395F"><b>Select another year, month or date to display:</b></font><br />';
echo '<table align = "Center" width = "100%" cellspacing="2" cellpadding="2" border><tr>';
// get another year
echo '<td> Select a year: <br />';

// get the list of available years
$query4 = "SELECT year from temp_years ORDER BY year DESC";

$result4 = $db->executeQuery($query4);

// put the results in an array
while ($result4->next()) {
    $row = $result4->getCurrentValuesAsHash();
     $years_avail[] = $row['year']; }
//begin the html form to select another year
echo '<form action="show_yrstat.php?" method="post">';
echo '<select name="year">';
foreach ($years_avail as $key => $value) {
   echo "<option value=\"$value\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get statistics" />
</form>';
echo '</td>';
// get another month
echo '<td> Select a month: <br />';
echo '<form action="show_monstat.php?" method="post">';
echo '<select name="month">';
foreach ($months as $key => $value) {
   echo "<option value=\"$key\"> $value</option>\n";
}
echo '</select>
<input type="submit" name="submit" value="Get statistics" />
</form>';
echo '</td>';
// get another date
echo '<td>Select a date: <br />';
echo '<form action="show_datestat.php?" method="post">';
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

require ('water_temp_footer.php');

?>





   



