<?php

require_once "MimeTypes.php";

use Test\Constants\MimeTypes;

/** this function is pretty limited, meh. */
function prepare_get_request(CurlHandle $curl, string $server_addr): void {
	$headers = array(
		"Accept" => MimeTypes::JSON,
		"Content-Type" => MimeTypes::JSON
	);

	curl_setopt($curl, CURLOPT_URL, $server_addr);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
}

/**
 * $uri is in the form of "k=v" the separator is "&"
 * example: "k1=v1&k2=v2"
*/
function prepare_post_request(CurlHandle $curl, string $server_addr, string $uri): void {
	$headers = array(
		"Accept" => MimeTypes::JSON,
		"Content-Type" => MimeTypes::XWWW_FORM_ENCODED,
	);

	curl_setopt($curl, CURLOPT_URL, $server_addr);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POST, true);
	// https://pt.stackoverflow.com/questions/420960/requisi%C3%A7%C3%A3o-curl-post-com-php
	curl_setopt($curl, CURLOPT_POSTFIELDS, $uri);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
}
