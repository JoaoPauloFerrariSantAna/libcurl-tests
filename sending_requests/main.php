<?php

define("REQUEST_URL", "https://jsonplaceholder.typicode.com");
define("REQUEST_ROUTE", "/users");
define("WAIT_TIME", 5);

/** will pool a class called ResponseHandler with default config */
function poolResponseHandler(): stdClass {
	$ResponseHandler = new stdClass();

	/**
	 * ResponseHandler::data is a array
	 * it holds the data that is returned from the server
	*/
	$ResponseHandler->response = array();

	return $ResponseHandler;
}

function pprint_reqs(array $req): void {
	printf("- %s, %s (%d).\n", $req["username"], $req["name"], $req["id"]);
	printf(">>> Contact is %s and lives at %s (zipcode: %s)\n",
		$req["email"], $req["address"]["street"], $req["address"]["zipcode"]
	);
}

function pprint_err_msg(string $msg): void {
	printf(">>> %s\n", $msg);
	exit(1);
}

function send_reqs(CurlHandle $handler, stdClass $resp_handler): void {
	for($i = 1; $i <= 10; $i++) {
		curl_setopt($handler, CURLOPT_URL, REQUEST_URL.REQUEST_ROUTE."/$i");
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

		$resp_handler->response = curl_exec($handler);

		if($resp_handler->response == false) {
			pprint_err_msg("Failed to make request at given url ".REQUEST_URL. "/$i");
		}

		$data = json_decode($resp_handler->response, true);

		pprint_reqs($data);

		sleep(WAIT_TIME);
	}
}

function send_req(CurlHandle $handler, stdClass $response): void {
	// will set the request to the giving URL
	curl_setopt($handler, CURLOPT_URL, REQUEST_URL.REQUEST_ROUTE."/1");

	// supressess stdout
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

	$response->response = curl_exec($handler);

	if($response->response == false) {
		pprint_err_msg("Failed to make request at given url ".REQUEST_URL);
	}

	printf("%s\n", $response->response);
}

function main(): int {
	$responseHandler = poolResponseHandler();
	$curl = curl_init();

	// send_reqs($curl, $responseHandler);
	send_req($curl, $responseHandler);

	curl_close($curl);
	return 0;
}

main();
