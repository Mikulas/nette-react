<?php

$sample = 1e3;

$start = microtime(TRUE);
for ($i = 0; $i < $sample; ++$i) {
	exec('curl http://127.0.0.1:1337/');
	echo "\r                \r$i/$sample";
}
echo "\r               \rreact benchmark done\n";
$react = microtime(TRUE) - $start;

$start = microtime(TRUE);
for ($i = 0; $i < $sample; ++$i) {
	exec('curl http://localhost/reactnette/');
	echo "\r                \r$i/$sample";
}
echo "\r               \rapache benchmark done\n";
$apache = microtime(TRUE) - $start;

echo "apache: $apache\n";
echo "react: $react\n";
echo "React is " . $apache/$react . " times faster\n";
