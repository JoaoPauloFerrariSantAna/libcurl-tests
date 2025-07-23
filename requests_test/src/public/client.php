<?php 


require_once "request_senders.php";

use function Test\Senders\populate_user;
use function Test\Senders\get_user;

function main(): int {
	$user = null;
	populate_user("John", "pass123");
	$user = json_decode(get_user(), true);
	print_r($user);
	return 0;
}

main();
