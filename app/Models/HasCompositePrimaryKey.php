<?php
namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HasCompositePrimaryKey{

	public function getIncrementing(){
		return false;
	}
	
	public function getKeyName(){
		return '_' . implode('_', $this->primaryKey);
	}
	
	public function getKey(){
		$attributes = [];
		foreach ($this->primaryKey as $key) {
			$attributes[] = $this->getAttribute($key);
		}
		$value = implode('-', $attributes);
		$this->setAttribute($this->getKeyName(), $value);
		return $value;
	}

	protected function setKeysForSaveQuery(Builder $query){
		foreach ($this->primaryKey as $key) {
			if(isset($this->$key))
				$query->where($key, '=', $this->$key);
			else
				throw new Exception(__METHOD__ . 'Missing part of primary key: '. $key);
		}
		return $query;
	}

	public static function find($composite_id, $columns = ['*']){
		$ids = explode('-', $composite_id);
		$me = new self;
		$query = $me->newQuery();
		foreach ($me->primaryKey as $index => $key) {
			$query->where($key, '=', $ids[$index]);
		}
		return $query->first($columns);
	}

	public static function findOrFail($composite_id, $columns = ['*']){
		$result = self::find($composite_id, $columns);
		if (!is_null($result)) {
			return $result;
		}
		throw (new ModelNotFoundException())->setModel(
			__CLASS__, $composite_id
		);
	}

	public function refresh(){
		if (!$this->exists) {
			return $this;
		}
		$this->setRawAttributes(
			static::findOrFail($this->getKey())->attributes
		);
		$this->load(collect($this->relations)->except('pivot')->keys()->toArray());
		return $this;
	}

}
?>