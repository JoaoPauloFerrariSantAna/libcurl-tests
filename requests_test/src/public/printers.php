<?php

namespace Test\printers;

function pprintErrMsg(string $msg): void {
	printf(">>> %s\n", $msg);
	exit(1);
}

