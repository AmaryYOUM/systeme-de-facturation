<?php
class Prestation extends Model{
    var $validate = array(
        'intitule_prestat' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser l\'intitulé de la prestation'
        ),
        'montant_prestat' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser le montant'
        )
    );

    function validates($data){
        $errors = array();
        foreach ($this->validate as $k=>$v) {
            if (!isset($data->$k)) {
                $errors[$k] = $v['message'];
            }else {
                if ($v['rule'] == 'notEmpty'){
                    if(empty($data->$k)) {
                    $errors[$k] = $v['message'];
                 }
                }elseif(!preg_match('/^'.$v['rule'].'$/',$data->$k)){
                    $errors[$k] = $v['message'];
                }
            }
        }
        $this->errors = $errors;
        if (isset($this->Form)) {
            $this->Form->errors = $errors;
        }
        if (empty($errors)) {
            return true;
        }
        return false;
    }

    public function find_prestat($req){
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
            $sql .= ' ORDER BY '.$req['order'].' ASC ';
        }

        //construction de la condition LIMIT
        if (isset($req['limit'])){
            $sql .= ' LIMIT '.$req['limit'];
        }

        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

}
