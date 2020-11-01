<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Validate {

	public function inArray($haystack){
		return function ($needle) use ($haystack) {
			if(!in_array($needle,$haystack)){
				return false;
			}
			else 
				return true;
		};
	}

}
 