<?php
// Connection configuration
$db = '127.0.0.1:1521/XE';  // Example: '127.0.0.1/orcl'
$username = 'SYSTEM';
$password = '1234';

// Connect to Oracle:
$conn = oci_connect($username, $password, $db);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Perform a query:
$sql = 'SELECT * FROM employees';
$stid = oci_parse($conn, $sql);
oci_execute($stid);

// Fetch results:
while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
    echo "<pre>"; print_r($row); echo "</pre>";
}

// Clean up
oci_free_statement($stid);
oci_close($conn);
?>
