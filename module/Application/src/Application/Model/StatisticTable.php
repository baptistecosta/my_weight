<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class StatisticTable {

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this->tableGateway->select(function($select) {
			$select->order(['date DESC']);
		});
		return $resultSet;
	}

	public function getStatistic($id) {
		$id = (int)$id;
		$rowset = $this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveStatistic(Statistic $statistic) {
		$data = [
			'weight' => $statistic->weight,
			'muscleMass' => $statistic->muscleMass,
			'bodyFat' => $statistic->bodyFat,
			'bodyWater' => $statistic->bodyWater,
		];

		$id = (int)$statistic->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getStatistic($id)) {
				$this->tableGateway->update($data, ['id' => $id]);
			} else {
				throw new \Exception('Statistic id does not exist');
			}
		}
	}

	public function deleteStatistic($id) {
		$this->tableGateway->delete(['id' => (int)$id]);
	}
}