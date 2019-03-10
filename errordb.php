<?php
$arr = $stmt->errorInfo();
if (isset($arr[2])) {// we have an error
echo "<br/> Database Error Code: ".$arr[0]; echo "<br/> Driver Error Code: ".$arr[1];
echo "<br/> Database Error Message: ".$arr[2]; exit();
}
?>