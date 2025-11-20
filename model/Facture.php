<?php
class Facture extends Model{
    var $validate = array(
        'prestation_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser la prestation'
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
        public $primarykey = 'id';
        public function sauvegarder($data){
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

    public function CountFact($conditions){
        $res = $this->findFirst(array(
            'fields'=>'COUNT(DISTINCT '.$this->numero.') as count',
            'conditions' => $conditions,
        ));
        
        return $res->count;
    }

public function getNextNumeroFacture() {
    $sql = "SELECT valeur FROM parametres WHERE cle = 'numero_facture'";
    $result = $this->db->query($sql)->fetch(PDO::FETCH_OBJ);

    if ($result && isset($result->valeur)) {
        return $result->valeur;
    } else {
        // Retourne 1 par défaut ou déclenche une erreur contrôlée
        return 1;
    }
}


public function incrementerNumeroFacture() {
    // Incrément uniquement après une sauvegarde réussie
    $sql = "UPDATE parametres SET valeur = valeur + 1 WHERE cle = 'numero_facture'";
    $this->db->query($sql);
}


    /*
    public function CountFact($conditions = [], $numerotation = null) {
    if ($numerotation === null) {
        $numerotation = $this->primarykey; // Par défaut : 'id'
    }

    $res = $this->findFirst([
        'fields' => 'COUNT(DISTINCT ' . $numerotation . ') as count',
        'conditions' => $conditions
    ]);

    return isset($res->count) ? $res->count : 0;
}
 */

}