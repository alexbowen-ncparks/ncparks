<?phpwhile($row=mysqli_fetch_array($result)){extract($row);// ************** Display Subtotals *****************if($check!="" and $checkAcct!=$ncasnum){// 8 numeric fields$subSpent0203=number_format($subTotSpent0203,2);// 1$subSpent0304=number_format($subTotSpent0304,2);// 2$subSpent0405=number_format($subTotSpent0405,2);// 3$subinc0506Form=number_format($subTotinc0506,2);// 4$subrequest0506Form=number_format($subTotrequest0506,2);// $subTotspent0506Form=number_format($subTotspent0506,2);// $subavailable=number_format($subTotavailable,2);// echo"<tr bgcolor='#C0C0C0'><td align='right' colspan='6'>Subtotal:</td><td align='right'>$subSpent0203</td><td align='right'>$subSpent0304</td><td align='right'>$subSpent0405</td><td align='right'>$subinc0506Form</td><td align='right'>&nbsp;</td><td align='right'>$subrequest0506Form</td><td align='right'>$subTotspent0506Form</td><td align='right'>$subavailable</td></tr>";$subTotSpent0203="";$subTotSpent0304="";$subTotSpent0405="";$subTotinc0506="";$subTotrequest0506="";$subTotspent0506="";$subTotavailable="";$checkAcct=$ncasnum;}$spent0203F=number_format($spent0203,2);// Spent 0203$spent0304F=number_format($spent0304,2);// Spent 0304$spent0405F=number_format($spent0405,2);// Spent 0405$inc0506F=number_format($inc0506,2);// INC0506$inc0506_percF=number_format($inc0506_perc,2)."%";// $request0506F=number_format($request0506,2);// request0506$spent0506F=number_format($spent0506,2);// Spent0506$availableF=number_format($available,2);// available// Record Displayecho"<tr><td align='right'>$ncasnum</td><td align='right'>$description</td><td align='right'>$section</td><td align='right'>$dist</td><td align='right'>$parkcode</td><td align='right'>$center</td><td align='right'>$spent0203F</td><td align='right'>$spent0304F</td><td align='right'>$spent0405F</td><td align='right'>$inc0506F</td><td align='right'>$inc0506_percF</td><td align='right'>$request0506F</td><td align='right'>$spent0506F</td><td align='right'>$availableF</td></tr>";$totSpent0203=$totSpent0203+$spent0203;$subTotSpent0203=$subTotSpent0203+$spent0203;$totSpent0304=$totSpent0304+$spent0304;$subTotSpent0304=$subTotSpent0304+$spent0304;$totSpent0405=$totSpent0405+$spent0405;$subTotSpent0405=$subTotSpent0405+$spent0405;$totinc0506=$totinc0506+$inc0506;$subTotinc0506=$subTotinc0506+$inc0506;$totspent0506=$totspent0506+$spent0506;$subTotspent0506=$subTotspent0506+$spent0506;$totrequest0506=$totrequest0506+$request0506;$subTotrequest0506=$subTotrequest0506+$request0506;$totavailable=$totavailable+$available;$subTotavailable=$subTotavailable+$available;$check=1;$checkAcct=$ncasnum;}// end While// Final SubTotal// 8 numeric fields$subSpent0203=number_format($subTotSpent0203,2);// 1$subSpent0304=number_format($subTotSpent0304,2);// 2$subSpent0405=number_format($subTotSpent0405,2);// 3$subinc0506Form=number_format($subTotinc0506,2);// 4$subTotrequest0506Form=number_format($subTotrequest0506,2);// 6$subTotspent0506Form=number_format($subTotspent0506,2);// 7$subavailable=number_format($subTotavailable,2);// 8echo"<tr bgcolor='#C0C0C0'><td align='right' colspan='6'>Subtotal:</td><td align='right'>$subSpent0203</td><td align='right'>$subSpent0304</td><td align='right'>$subSpent0405</td><td align='right'>$subinc0506Form</td><td align='right'>&nbsp;</td><td align='right'>$subTotrequest0506Form</td><td align='right'>$subTotspent0506Form</td><td align='right'>$subavailable</td></tr>";// Footer Totals$totSpent0203F=number_format($totSpent0203,2);$totSpent0304F=number_format($totSpent0304,2);$totSpent0405F=number_format($totSpent0405,2);$totinc0506F=number_format($totinc0506,2);$totrequest0506F=number_format($totrequest0506,2);$totspent0506F=number_format($totspent0506,2);$totavailableF=number_format($totavailable,2);echo"<tr bgcolor='yellow'><td align='right' colspan='6'><b>Grand Totals:</b></td><td align='right'><b>$totSpent0203F</b></td><td align='right'><b>$totSpent0304F</b></td><td align='right'><b>$totSpent0405F</b></td><td align='right'><b>$totinc0506F</b></td><td align='right'><b>&nbsp;</b></td><td align='right'><b>$totrequest0506F</b></td><td align='right'><b>$totspent0506F</b></td><td align='right' bgcolor='white'><b>$totavailableF</b></td></tr>";echo "<th>Account</th><th>Description</th><th>Section</th><th>DIST</th><th>Park</th><th>Center</th><th>Spent 0203</th><th>Spent 0304</th><th>Spent 0405</th><th>Inc 0506</th><th>Inc 0506 %</th><th>Request 0506</th><th>Spent 0506</th><th>Available</th></table></div></body></html>";?>