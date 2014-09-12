<?php

/**
 * Implementation of THEX tree hash algorithm, with any hash function as the internal
 * algorithm (using the approach as revised in December 2002, to add unique
 * prefixes to leaf and node operations)
 * 
 * Uses a running stack of interim hashes to be space-efficient. 
 *
 * Translated to PHP by TOGoS.  Based on Java implementation 
 * (PD) 2003-2006 The Bitzi Corporation
 * See http://bitzi.com/publicdomain for more info.
 */
class TOGoS_TreeHasher_CalcState
{
	protected $blockSize;
	protected $hashFunction;
	protected $buffer = '';
	protected $nodes = array();
	protected $blockCount = 0;
	
	public function __construct( $blockSize, $hashFunction ) {
		$this->blockSize = $blockSize;
		$this->hashFunction = $hashFunction;
	}
	
	public function update( $data ) {
		while( strlen($data) >= ($remaining = $this->blockSize - strlen($this->buffer)) ) {
			$this->buffer .= substr($data, 0, $remaining);
			$this->blockUpdate();
			$this->buffer = '';
			$data = substr($data, $remaining);
		}
		$this->buffer .= $data;
	}
	
	/**
	 * Returns the digest.
	 * The instance will be worthless after this is called.
	 */
	public function digest() {
		if( strlen($this->buffer) > 0 or count($this->nodes) == 0 ) {
			$this->blockUpdate();
		}
		while( count($this->nodes) > 1 ) {
			$this->composeNodes();
		}
		return $this->nodes[0];
	}
	
	protected function blockUpdate() {
		$this->nodes[] = call_user_func($this->hashFunction, "\0".$this->buffer);
		++$this->blockCount;
		$interimNode = $this->blockCount;
		while( ($interimNode % 2) == 0 ) {
			// Oh sweet we can combine the last 2 nodes.
			$this->composeNodes();
			$interimNode >>= 1;
		}
	}
	
	protected function composeNodes() {
		$right = array_pop($this->nodes);
		$left  = array_pop($this->nodes);
		$this->nodes[] = call_user_func($this->hashFunction, "\1".$left.$right);
	}
}
