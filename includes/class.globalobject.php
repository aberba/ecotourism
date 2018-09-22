<?php
class GlobalObject {

	protected static $table_name    = "";

	protected static $table_columns = [];

	public $id;

    /* Common Class Methods
    *****************************************************************/
	public static function countAll() {
		global $Database;
		$result = $Database->query("SELECT COUNT(*) as num FROM ".static::$table_name);
		return $Database->fetchData($result)->num;
	}

	public static function countAllPublished() {
		global $Database;
		$result = $Database->query("SELECT COUNT(*) as num FROM ".static::$table_name." WHERE publish = '1'");
		return $Database->fetchData($result)->num;
	}

    public static function findById($id=0) {
    	global $Database;

	    $sql = "SELECT * FROM ". static::$table_name. " WHERE id='".
	    	    (int)$Database->cleanData($id). "' LIMIT 1";

	    $records = static::findBySQL($sql);
	    return (!empty($records)) ? $records[0] : false;
	}

	public static function findAll() {
	    return static::findBySQL("SELECT * FROM ". static::$table_name);
	}

	public static function findBySQL($sql="") {
		global $Database;

	    $result = $Database->query($sql);
	    if (!$result || $Database->numRows($result) < 1) return false;

        $output = array();
	    while ($record = $Database->fetchData($result)) {
	        $output[] = static::instantiate($record);
	    }
	    return $output;
	}

	protected static function instantiate($record) {
		$object = new static();

		foreach ($record as $column => $value) {
			if (static::hasColumn($column)) {
				$object->$column = $value;
			}
		}
		return $object;
	}

	protected static function getTableColumns() {
		return static::$table_columns;
	}

	protected static function hasColumn($column) {
		return in_array($column, static::getTableColumns()) ? true : false;
	}

	public function save() {
		return ( isset($this->id) ) ? $this->update() : $this->create();
	}

	protected function create() {
		global $Database;

        $column_values = [];
        foreach (static::getTableColumns() as $column) {
        	$column_values[] =  $Database->cleanData( $this->$column , "<a>");
        }

		$sql = "INSERT INTO " .static::$table_name . " (";
        $sql .= join(", ", static::getTableColumns());
		$sql .= ") VALUES ('";
		$sql .= join("', '", $column_values);
		$sql .= "')";

		if ($Database->query($sql)) {
			$this->id = $Database->insertId();
			return true;
		} else {
			return false;
		}
	}


	protected function update() {
		global $Database;

        $column_pairs = [];
		foreach (static::getTableColumns() as $col) {
			if ($col == "id") continue;
			$column_pairs[] = "{$col}='". $Database->cleanData( $this->$col ) ."'";
		}

        $sql  = "UPDATE " .static::$table_name. " SET ";
		$sql .= join(", ", $column_pairs);
		$sql .= " WHERE id='" .$Database->cleanData( $this->id ). "' LIMIT 1";

		$result = $Database->query($sql);
		return ( $Database->affectedRows() == 1 ) ? true : false;
	}

	public function delete() {
		global $Database;

		$sql  = "DELETE FROM ". static::$table_name. " WHERE id='";
		$sql .= $Database->cleanData($this->id) ."' LIMIT 1";
		$result = $Database->query($sql);

		return ($Database->affectedRows() == 1) ? true : false;
	}
}
?>
