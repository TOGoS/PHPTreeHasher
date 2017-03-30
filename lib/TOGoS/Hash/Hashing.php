<?php

interface TOGoS_Hash_Hashing {
	public function reset();
	public function update( $data );
	/** Finalizes the hash computation and returns the 'raw' (not hex encoded or anything) output as a byte string */
	public function digest();
}
