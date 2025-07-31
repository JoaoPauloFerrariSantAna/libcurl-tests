<?php

// yes, i'm still using this pseudo oop,
// just because there isn't structs here on PHP

define("FILE_URL", "ftp://demo:password@test.rebex.net/");
define("DOWNLOAD_PATH", "./");

function pprintErrMsg(string $msg): void {
	printf(">>> %s\n", $msg);
	exit(1);
}

function poolFileHandler(): stdClass {
	$FileHandler = new stdClass();

	// forgot that i could use null
	$FileHandler->data_ = null;

	/* meant to be used only when storing in the client's FS */
	$FileHandler->resource_ = null;

	/* this is meant to be used only when writing into the file */
	$FileHandler->has_writing_failed_ = false;

	$FileHandler->fileName = "readme.txt";

	$FileHandler->pathToFile = DOWNLOAD_PATH . $FileHandler->fileName;

	return $FileHandler;
}

function prepareFileRequest(CurlHandle $curl, string $fileName): void {
	curl_setopt($curl, CURLOPT_URL, FILE_URL . $fileName);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
}

function sendRequest(CurlHandle $sender, stdClass $fHandler): void {
	// i hate the fact that there are two differents return types 
	$fHandler->data_ = curl_exec($sender);

	if(!$fHandler->data_)
		pprintErrMsg("Failure to download file " .$fHandler->fileName_);
	
}

/** will return a resource (pointer to a file)  */
function createFile(stdClass $fHandler) {
	$fstream = fopen($fHandler->pathToFile, "w+");

	if(!$fstream)
		pprintErrMsg("Failed to write into file " . $fHandler->pathToFile);
	
	return $fstream;
}

function writeIntoFs(stdClass $fHandler) {
	$fHandler->resource_ = createFile($fHandler);
	$fHandler->has_writing_failed_ = fwrite($fHandler->resource_, $fHandler->data_);

	if(!$fHandler->has_writing_failed_)
		pprintErrMsg("Failed to write into file " . $fHandler->fileName);
}

function main(): int {
	$curl = curl_init();
	$incomingFile = poolFileHandler();

	prepareFileRequest($curl, $incomingFile->fileName);
	sendRequest($curl, $incomingFile);
	curl_close($curl);
	writeIntoFs($incomingFile);
	fclose($incomingFile->resource_);

	return 0;
}

main();
