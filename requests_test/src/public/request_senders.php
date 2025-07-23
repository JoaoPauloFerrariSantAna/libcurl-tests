<?php

namespace Test\Senders;

require_once "request_preparators.php";
require_once "printers.php";
require_once "HttpConstants.php";

use Test\Constants\HttpConstants;
use function Test\printers\pprintErrMsg;

define("SERVER_URL", "http://127.0.0.1:5000");

function get_user(): string {
	// we'll just return the response 'cause we are already
	// are dealing with the err here
	$data = null;
	$curl = curl_init();

	prepare_get_request($curl, SERVER_URL . "/get_user_data");
	$data = curl_exec($curl);

	if(!$data)
		pprintErrMsg("Could not make request: ".curl_error($curl));

	curl_close($curl);
	return $data;
}

function populate_user(string $uname, string $passwd): void {
	$data = null;
	$curl = curl_init();

	// we are sending $user_info because i'm using x-www-form-urlencoded
	prepare_post_request(
		$curl,
		SERVER_URL . "/post_user_info",
		"name=".$uname."&pass=".$passwd
	);
	$data = curl_exec($curl);

	if(!$data) pprintErrMsg(curl_error($curl) . PHP_EOL);

	$data = json_decode($data, true);

	if($data["status"] == HttpConstants::UNPROCESSABLE_ENTITITY)
		pprintErrMsg("Failed to register data! (sended to ".SERVER_URL."/post_user_info)");

	curl_close($curl);
}
