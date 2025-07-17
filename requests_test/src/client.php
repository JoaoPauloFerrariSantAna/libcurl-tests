<?php 

define("SERVER_URL", "http://127.0.0.1:5000/get_dummy_data");

function prepare_request(CurlHandle $curl): void {
	$http_headers = array(
		"Accept" => "application/json",
		"Content-Type" => "application/json"
	);

	curl_setopt($curl, CURLOPT_URL, SERVER_URL);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
}

function make_request(): string {
	$curl = curl_init();

	/*
	 * we'll just return the response 'cause we are already
	 * dealing with the err here
	*/
	$data = null;

	prepare_request($curl);

	$data = curl_exec($curl);

	if($data == false) {
		printf("Could not make request at %s\nReason: %s\n", SERVER_URL, curl_error($curl));
		exit(1);
	}

	curl_close($curl);

	return $data;
}

function main(): int {
	$fdata = json_decode(make_request(), true);

	echo $fdata["username"] . PHP_EOL;

	return 0;
}

main();
