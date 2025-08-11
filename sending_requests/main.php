<?php

define("REQUEST_URL", "https://jsonplaceholder.typicode.com");
define("REQUEST_ROUTE", "/users");
define("WAIT_TIME", 5);

function pprintReqs(array $req): void {
	printf("- %s, %s (%d).\n", $req["username"], $req["name"], $req["id"]);
	printf(">>> Contact is %s and lives at %s (zipcode: %s)\n",
		$req["email"], $req["address"]["street"], $req["address"]["zipcode"]
	);
}

function pprintErrMsg(string $msg): void {
	printf(">>> %s\n", $msg);
	exit(1);
}

function sendReqs(CurlHandle $curl): void {
	for($i = 1; $i <= 10; $i++) {
		curl_setopt($curl, CURLOPT_URL, REQUEST_URL . REQUEST_ROUTE."/$i");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$resp = curl_exec($curl);

		if(!$resp)
			pprintErrMsg("Failed to make request at given url ".REQUEST_URL. "/$i");

		$data = json_decode($resp, true);

		pprintReqs($data);

		sleep(WAIT_TIME);
	}
}

function sendReq(CurlHandle $curl): void {
	// will set the request to the giving URL
	curl_setopt($curl, CURLOPT_URL, REQUEST_URL.REQUEST_ROUTE."/1");
	// supressess stdout
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$resp = curl_exec($curl);

	if(!$resp)
		pprintErrMsg("Failed to make request at given url ".REQUEST_URL);

	printf("%s\n", $resp);
}

function main(): int {
	$curl = curl_init();

	sendReqs($curl);
	sendReq($curl);

	curl_close($curl);
	return 0;
}

main();
