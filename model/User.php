<?php
class User extends Model{
    var $validate = array(
        'prenom_user' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser le prenom'
        ),
        'nom_user' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser le nom'
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


    public $login = 'login';

     public function saveonline($data) {
        $loginField = $this->login; // ex: 'login'
        
        // Vérifier que le login est fourni
        if (!isset($data->$loginField) || empty($data->$loginField)) {
            return false;
        }
    
        $fields = [];
        $params = [];
    
        foreach ($data as $key => $value) {
            // Ne pas inclure la clé d'identification (login) dans SET
            if ($key !== $loginField) {
                $fields[] = "$key = :$key";
                $params[":$key"] = $value;
            } else {
                // Ajouter la condition WHERE
                $params[":$loginField"] = $value;
            }
        }
    
        // S'assurer qu'on a des champs à mettre à jour
        if (empty($fields)) {
            return false;
        }
    
        $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $fields) . ' WHERE ' . $loginField . ' = :' . $loginField;
    
        try {
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($params);
            return $result; // true si succès
        } catch (PDOException $e) {
            // Log l'erreur si tu as un logger, sinon juste return false
            error_log("Erreur lors de saveonline(): " . $e->getMessage());
            return false;
        }
    }

    

    public function majlogin($data) {
        $key = $this->login;
        $fields = array();
        $d = array();
    
        // Construction des champs pour la mise à jour
        foreach ($data as $k => $v) {
            if ($k!=$this->login) {
                $fields[] = "$k=:$k";
                $d[":$k"] = $v;
            }elseif (!empty($v)) {
                $d[":$k"] = $v;
            }
        }
    
        // S'assurer que l'identifiant de l'utilisateur est défini
        if (isset($data->$key) && !empty($data->$key)) {
            // Construction de la requête SQL
            $sql = 'UPDATE ' . $this->table . ' SET ' . implode(',', $fields) . ' WHERE ' . $key . ' = :' . $key;
            $this->id = $data->$key; // Met à jour l'ID de l'utilisateur
            $pre = $this->db->prepare($sql);
            $pre->execute($d);           
        }
    }

}
