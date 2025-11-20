<?php
#[\AllowDynamicProperties]

class Model{

    static $connections = array();
    public $conf = 'default';
    public $table = false;
    public $db;
    public $primarykey = 'id';
    public $foreignkey1 = 'prestation_id';
    public $k_id;
    public $id;
    public $errors = array();
    public $form;
    public $montant_global = 'montant_global';
    public $montant = 'montant';
    public $numero = 'num';
    public $num;

    public function __construct(){
        //j'initialise quelques variable
        if ($this->table === false) {
        $this->table = strtolower(get_class($this)).'s';
        }
        //connexion à la base
        $conf = Conf::$databases[$this->conf];
        if (isset(Model::$connections[$this->conf])) {
            $this->db = Model::$connections[$this->conf];
            return true;
        }
        try{
            $pdo = new PDO('mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
            $conf['login'],
            $conf['password'],
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

            Model::$connections[$this->conf] = $pdo;
            $this->db = $pdo;
        }catch(PDOException $e){
        if (Conf::$debug >= 1) {
            die($e->getMessage());   
        }else {
            die('impossible de se connecter à la base de données');
        }
    }
}

    public function find($req){
        $sql = 'SELECT ';
        if(isset($req['fields'])){
            if (is_array($req['fields'])) {
                $sql .= implode(', ',$req['fields']);
            }else {
                $sql .= $req['fields'];
            }
        }else {
            $sql .= '*';
        }
        $sql .= ' FROM '.$this->table.' as '.get_class($this).' ';
        //construction de la condition WHERE
        if (isset($req['conditions'])){
            $sql .= 'WHERE ';
            if (!is_array($req['conditions'])) {
                $sql .= $req['conditions'];
            }else {
                $cond = array();
                foreach($req['conditions'] as $k=>$v) {
                    if (is_array($v) ) {
                        foreach ($v as $key => $value) {
                            $cond[] = "$key=$value";
                        }
                        
                    }else {
                        if (!is_numeric($v)) {
                            $v =  $this->db->quote($v) ;
                        }
                        $cond[] = "$k=$v";
                    }
                }
            $sql .= implode(' AND ',$cond);
            }
        }
        if (isset($req['group'])){
            $sql .= ' GROUP BY '.$req['group'];
        }
        if (isset($req['order'])){
            $sql .= ' ORDER BY '.$req['order'].' DESC ';
        }
        if (isset($req['order_asc'])){
            $sql .= ' ORDER BY '.$req['order_asc'].' ASC ';
        }
        //construction de la condition LIMIT
        if (isset($req['limit'])){
            $sql .= ' LIMIT '.$req['limit'];
        }

        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($req){
        return current($this->find($req));
    }
    
    function get($entityName){
        $sql = 'SELECT ';

        if (isset($req['fields'])){
            if (is_array($req['fields'])) {
                $sql .= implode(', ',$req['fields']);
            }else {
                $sql .= $req['fields'];
            }
        }else {
            $sql .= '*';
        }

        $sql .= ' FROM '.$this->table.' as '.get_class($this).' ';
        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }


    public function findCount($conditions){
        $res = $this->findFirst(array(
            'fields'=>'COUNT('.$this->primarykey.') as count',
            'conditions' => $conditions,
        ));
        return $res->count;
    }

/*

*/
    public function sum($conditions){
        $query = $this->findFirst(array(
            'fields' => 'SUM('.$this->montant.') as sum',
            'conditions' => $conditions,
        ));
        return $query->sum;
    }

    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE {$this->primarykey} = $id";
        $this->db->query($sql);
    }

    public function deleteByNumeroFacture($numero) {

        // Supprimer la facture elle-même (si nécessaire)
        $sql = "DELETE FROM {$this->table} WHERE {$this->numero} = ?";
        $this->db->prepare($sql)->execute([$numero]);
    }

    public function save($data){
        $key = $this->primarykey ;
        $fields = array();
        $d = array();
        foreach ($data as $k => $v) {
            if ($k!=$this->primarykey) {
                $fields[] = "$k=:$k";
                $d[":$k"] = $v;
            }elseif (!empty($v)) {
                $d[":$k"] = $v;
            }
        }

        if(isset($data->$key) && !empty($data->$key)) {
            $sql = 'UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE '.$key.'=:'.$key;
            $this->id = $data->$key;
            $action = 'update';
        }else {
            $sql = 'INSERT INTO '.$this->table.' SET '.implode(',',$fields);
            $action = 'insert';
        }
        $pre = $this->db->prepare($sql);
        $pre->execute($d);
        if ($action == 'insert') {
            $this->id = $this->db->lastInsertId();
        }
    }
}