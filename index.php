<?php
session_start();

require_once 'common.php';
require_once 'common_js.php';

echo '<html>';
echo '<head>';

echo '</head>';
echo '<body>';
unset($_SESSION['login']);
unset($_SESSION['password']);
echo '
<form method=post action=start_dc.php>
<table style="background-color:lightblue;"" align=center class=border>
<tr><th colspan=2>New Civil Hospital Surat</th></tr>
<tr><th  colspan=2>Discharge Card<br>(For clinicians only)</th></tr>
<tr>
<td>Login ID</td>
<td><input style="width:100%" type=text name=login placeholder=Username></td>
</tr>
<tr>
<td>Password</td>
<td><input  style="width:100%" type=password name=password  placeholder=Password></td>
</tr>
<tr>
<td colspan=2 align=center><input type=submit name=action value=Login></td>
</tr>
</table>
</form> ';

echo '</body></html>';

?>
