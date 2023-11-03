<?php
// Check the default session settings
echo "session.gc_maxlifetime: " . ini_get("session.gc_maxlifetime") . " seconds<br>";
echo "session.cookie_lifetime: " . ini_get("session.cookie_lifetime") . " seconds<br>";
echo "session.gc_probability: " . ini_get("session.gc_probability") . "<br>";
echo "session.gc_divisor: " . ini_get("session.gc_divisor") . "<br>";
echo "session.use_strict_mode: " . (ini_get("session.use_strict_mode") ? "On" : "Off") . "<br>";
echo "session.use_cookies: " . (ini_get("session.use_cookies") ? "On" : "Off") . "<br>";
// Add more session settings you want to check
?>
