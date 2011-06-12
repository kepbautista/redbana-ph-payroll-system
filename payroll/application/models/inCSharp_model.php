<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inCSharp_model extends CI_Model {

	function __construct()
	{
		/*
			abe | made | 09JUN2011_2002
			
			functions StartsWith and StartsWithOld are from http://www.jonasjohn.de/snippets/php/starts-with.htm, retrieved during above-mentioned date.
		*/
		parent::__construct();		
	}
	
	function StartsWith($Haystack, $Needle){
		// Recommended version, using strpos
		return strpos($Haystack, $Needle) === 0;
	}
	 
	// Another way, using substr
	function StartsWithOld($Haystack, $Needle){ 
		return substr($Haystack, 0, strlen($Needle)) == $Needle;
	}
	
}//class