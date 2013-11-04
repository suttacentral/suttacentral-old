<html><body><h1>
<?php
class TestConstructor
{
	public $x;
	
	public function __construct($aParam)
	{
		$this->x = $aParam;
	}
}

$test = new TestConstructor("It works!");

echo $test->x;

?>
</h1></body></html>
