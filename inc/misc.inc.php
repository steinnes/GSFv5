<?php
function time_elapsed($ptime) {
	$etime = time() - $ptime;

	if ($etime < 1) {
		return '0 sekúndum';
	}

	$a = array(
		12 * 30 * 24 * 60 * 60  =>  array('ári','árum'),
		30 * 24 * 60 * 60       =>  array('mánuði','mánuðum'),
		24 * 60 * 60            =>  array('degi','dögum'),
		60 * 60                 =>  array('klukkutíma','klukkutímum'),
		60                      =>  array('mínútu','mínutum'),
		1                       =>  array('sekúndu','sekúndum')
		);

	foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) {
			$r = round($d);
			return $r . ' ' . (($r-1) % 10 == 0 && $r != 11 ? $str[0] : $str[1]);
		}
	}
}
?>
