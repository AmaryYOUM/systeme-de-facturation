<?php
class PatientsController extends Controller{
    /**
     * Permet d'éditer une facture
     */
    function admin_edit($id = null){
        $perPage = 30;

        $this->loadModel('Patient');
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Prestation');
        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['id'] = '';
        if ($this->request->data) {
            if($this->Patient->validates($this->request->data)){                
                $this->Patient->save($this->request->data);
                $this->Session->setFlash('patient(e) modifié(e) avec succès');    
                $this->redirect('admin/factures/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->Patient->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $d['filtre'] = '';

        if (!empty($_GET['telephone_patient'])) {
            $condpat = array('telephone_patient' => $_GET['telephone_patient']);

            $d['patients'] = $this->Patient->find(array(
                'conditions' => $condpat,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['filtre'] = $_GET['telephone_patient'];
            $d['total_patient'] = $this->Patient->findCount($condpat);
            $d['page'] = ceil($d['total_patient'] / $perPage);
        }else {
            $d['patients'] = $this->Patient->find(array(
                'conditions' => $condition,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['total_patient'] = $this->Patient->findCount($condition);
            $d['page'] = ceil($d['total_patient'] / $perPage);
        }

        $this->set($d);
     }
     

     function agent_edit($id = null){
        $perPage = 30;

        $this->loadModel('Patient');
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Prestation');
        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['id'] = '';
        if ($this->request->data) {
            if($this->Patient->validates($this->request->data)){                
                $this->Patient->save($this->request->data);
                $this->Session->setFlash('patient(e) modifié(e) avec succès');    
                $this->redirect('agent/factures/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->Patient->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $d['filtre'] = '';

        if (!empty($_GET['telephone_patient'])) {
            $condpat = array('telephone_patient' => $_GET['telephone_patient']);

            $d['patients'] = $this->Patient->find(array(
                'conditions' => $condpat,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['filtre'] = $_GET['telephone_patient'];
            $d['total_patient'] = $this->Patient->findCount($condpat);
            $d['page'] = ceil($d['total_patient'] / $perPage);
        }else {
            $d['patients'] = $this->Patient->find(array(
                'conditions' => $condition,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['total_patient'] = $this->Patient->findCount($id);
            $d['page'] = ceil($d['total_patient'] / $perPage);
        }

        $this->set($d);
     }

    /**
     * Permet de supprimer un patient
     */
    
    function admin_delete($id){
        $this->loadModel('Patient');
        $this->loadModel('Facture');

        $fact = $this->Facture->find(array(
         'conditions' => array('patient_id'=>$id)
         ));

        if (empty($fact)) {
                $this->Patient->delete($id);
                $this->Session->setFlash('Patient(e) supprimé(e) avec succès');    
                $this->redirect('admin/patients/edit');             
        }else {
            $this->Session->setFlash('Le patient n\'a pas été supprimer car il est liée à au moins une facture, veuillez d\'abord supprimer toutes les factures liées');
            $this->redirect('admin/patients/edit'); 
        }
     }

     function delfiltre() {
        unset($_GET);
        $this->Session->setFlash('Filtre effacé');
        if ($this->Session->user('profil') == "admin") {
            $this->redirect('admin/patients/edit');
        }else {
            $this->redirect('agent/patients/edit');
        }
    }
}
