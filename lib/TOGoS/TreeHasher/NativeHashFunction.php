<?php

class TOGoS_TreeHasher_NativeHashFunction
{
	protected $algorithmName;
	
	public function __construct( $algorithmName ) {
		$this->algorithmName = $algorithmName;
	}
	
	public function __invoke( $data ) {
		return hash($this->algorithmName, $data, true);
	}
}
