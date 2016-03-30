<?php

class Test {
	public static function testArg(){
		return func_get_args();
	}
}

var_dump(Test::testArg("arg1","tot", "test"));