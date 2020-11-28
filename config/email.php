<?php

$from_name = env('DEFAULT_FROM_NAME', 'From Savyour');
$from_email = env('DEFAULT_FROM_EMAIL', 'no-reply@savyour.local');

return [
	'all-users' => [
		'subject' => 'savyour config subject',
		'from_name' => $from_name,
		'from_email' => $from_email,
	]
];