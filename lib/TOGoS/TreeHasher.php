<?php

class TOGoS_TreeHasher
{
	protected $blockSize;
	protected $hashFunction;
	
	public function __construct( $blockSize, $hashFunction ) {
		$this->blockSize = $blockSize;
		$this->hashFunction = $hashFunction;
	}
	
	public function hash( $subject ) {
		if( is_scalar($subject) ) {
			$subject = (string)$subject;
			$cs = new TOGoS_TreeHasher_CalcState($this->blockSize, $this->hashFunction);
			$cs->update($subject);
			return $cs->digest();
		} else {
			throw new Exception("Can't hash a ".gettype($subject));
		}
	}
	
	public function __invoke( $subject ) {
		return $this->hash($subject);
	}
	
	public static function nativeHashFunction($name) {
		return new TOGoS_TreeHasher_NativeHashFunction($name);
	}
	
	public static function tigerTree() {
		if( PHP_VERSION_ID < 50400 ) {
			return new TOGoS_TreeHasher(1024, new TOGoS_TreeHasher_FixedTigerHash());
		}
		return new TOGoS_TreeHasher(1024, self::nativeHashFunction('tiger192,3'));
	}
}
