<?php

namespace MyWeight\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MyTableHelper extends AbstractHelper {

	function __invoke() {
		return $this;
	}

	public function groupByMonths($rows, $dateGetter = 'getDate') {
		foreach ($rows as $r) {
			$groupByMonth[$r->{$dateGetter}()->format('Y-m')][] = $r;
		}
		return isset($groupByMonth) ? $groupByMonth : [];
	}
} 