<?php
if ($_POST && !$error) {
	$killed = 0;
	foreach ((array) $_POST["kill"] as $val) {
		if (queries("KILL " . intval($val))) {
			$killed++;
		}
	}
	query_redirect(queries(), $SELF . "processlist=", lang('%d process(es) has been killed.', $killed), $killed || !$_POST["kill"], false, !$killed && $_POST["kill"]);
}
page_header(lang('Process list'), $error);
?>

<form action="" method="post">
<table cellspacing="0">
<?php
$result = $dbh->query("SHOW PROCESSLIST");
for ($i=0; $row = $result->fetch_assoc(); $i++) {
	if (!$i) {
		echo "<thead><tr lang='en'><th>&nbsp;<th>" . implode("<th>", array_keys($row)) . "</thead>\n";
	}
	echo "<tr" . odd() . "><td><input type='checkbox' name='kill[]' value='$row[Id]'><td>" . implode("<td>", $row) . "\n";
}
$result->free();
?>
</table>
<p>
<input type="hidden" name="token" value="<?php echo $token; ?>">
<input type="submit" value="<?php echo lang('Kill'); ?>">
</form>
