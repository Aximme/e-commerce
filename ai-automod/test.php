<?php
$output = shell_exec("python3 /Applications/MAMP/htdocs/Miroff_Airplanes/ai-automod/check_insult.py 'test message'");
var_dump($output);
?>