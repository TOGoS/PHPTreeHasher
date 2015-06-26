<?php

/** For PHP <5.3 */
class TOGoS_TreeHasher_FixedTigerHash
{
	public function __invoke( $data ) {
		// Need to flip each 8 bytes of the output
		return implode("",
			array_map("strrev",
				str_split(hash("tiger192,3", $data, true), 8)));
	}
}
