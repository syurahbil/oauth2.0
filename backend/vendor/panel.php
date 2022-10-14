<?php

class DB extends PDO{

    const PARAM_host='localhost';
    const PARAM_port='3306';
    const PARAM_db_name='oauth2';
    const PARAM_user='syurahbil';
    const PARAM_db_pass='syurahbil123';

    public function __construct($options=null){
        parent::__construct('mysql:host='.DB::PARAM_host.';port='.DB::PARAM_port.';dbname='.DB::PARAM_db_name,
DB::PARAM_user,
DB::PARAM_db_pass,$options);
	    $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));
    }

    public function query($query){ //secured query with prepare and execute
        $args = func_get_args();
        array_shift($args); //first element is not an argument but the query itself, should removed

        $reponse = parent::prepare($query);
        $reponse->execute($args);
        return $reponse;

    }

}

class DBStatement extends PDOStatement {
    public $dbc;
    protected function __construct($dbc) {
        $this->dbc = $dbc;
    }
}
?>
