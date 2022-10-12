<?php
ini_set('display_errors',1);
$database="trails";
include '../../include/auth.inc';
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include '../../include/iConnect.inc';

mysqli_select_db($connection,$database);

include '../_base_top.php';
$include_path = get_include_path();
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<div>";
echo "<table>";
echo "<tr>
		<td class='head'>
			Welcome to the NC Trails Database app website.
		</td>
	</tr>";
echo "<tr>
		<td>
			<p>
				<font color='#99cc00' size='+1'>
					About the Trails Program
				</font>
			</p>
			<p>
				The North Carolina Trails Program originated in 1973 with the North Carolina Trails System Act and is dedicated to helping citizens, organizations and agencies plan, develop and manage all types of trails ranging from greenways and trails for hiking, biking and horseback riding to paddle trails and off-road vehicle trails.
			</p>
			<p>
				For more information visit the <a href=https://trails.nc.gov>NC Trails</a> website.
			</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>
				<font color='#99cc00' size='+1'>
					
				</font>
			</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
			<p>		</p>
		</td>
	</tr>";

//echo "<tr><td></td></tr>";

echo "	<tr>
			<td>
			</td>
		</tr>
	</table>
</div>";
include("footer.php");
?>