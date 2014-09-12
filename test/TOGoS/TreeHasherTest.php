<?php

class TOGoS_TreeHasherTest extends PHPUnit_Framework_TestCase
{
	protected $testVector = array(
		'' => '5d9ed00a030e638bdb753a6a24fb900e5a63b8e73e6c25b6',
		'Hello, world!' => 'd7fd324fed05cdf2d443859c46bafca8029967860d7f004e'
	);
	
	public function setUp() {
		$blobDir = dirname(__DIR__).'/blobs';
		$dh = opendir($blobDir);
		while( $e = readdir($dh) ) {
			if( $e[0] != '.' ) {
				$this->testVector[file_get_contents($blobDir.'/'.$e)] = $e;
			}
		}
	}
	
	public function testHashEmptyData() {
		$hasher = TOGoS_TreeHasher::tigerTree();
		foreach( $this->testVector as $str => $expectedHashHex ) {
			$actualHashHex = bin2hex($hasher->hash($str));
			$this->assertEquals($expectedHashHex, $actualHashHex, "Hash of \"$str\" did not match");
		}
	}
}
