<?php
class PrescripteursController extends Controller{

    /**
     * Permet d'éditer un utilisateur
     */ function admin_edit($id = null){
        $perPage = 30;

        $this->loadModel('Prescripteur');
        $this->loadModel('User');
        $this->loadModel('Service');

        $d['services'] = $this->Service->get($this->request->data);

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }

        $d['id'] = '';
        if ($this->request->data) {
            if($this->Prescripteur->validates($this->request->data)){                
                $this->Prescripteur->save($this->request->data);
                $this->Session->setFlash('Prescripteur modifié avec succès');    
                $this->redirect('admin/prescripteurs/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->Prescripteur->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $d['filtre'] = null;

        if (!empty($_GET['prenom_prescripteur'])) {
            $condprescripteur = array('tel_prescripteur' => $_GET['tel_prescripteur']);

            $d['prescripteurs'] = $this->Prescripteur->find(array(
                'conditions' => $condprescripteur,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
        
                $d['filtre'] = $_GET['tel_prescripteur'];
    
            $d['total_prescripteur'] = $this->Prescripteur->findCount($condprescripteur);
            $d['page'] = ceil($d['total_prescripteur'] / $perPage);
        }else {
            $d['prescripteurs'] = $this->Prescripteur->find(array(
                'conditions' => $condition,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['total_prescripteur'] = $this->Prescripteur->findCount($condition);
            $d['page'] = ceil($d['total_prescripteur'] / $perPage);
        }


        $this->set($d);
     }

    /**
     * Permet de supprimer une facture
     */

    function admin_delete($id){
        $this->loadModel('Prescripteur');
        $this->loadModel('Facture');

        $fact = $this->Facture->find(array(
         'conditions' => array('prescripteur_id'=>$id)
         ));

        if (empty($fact)) {
                $this->Prescripteur->delete($id);
                $this->Session->setFlash('Prescripteur(e) supprimé(e) avec succès');    
                $this->redirect('admin/prescripteurs/edit');             
        }else {
            $this->Session->setFlash('Le prescripteur n\'a pas été supprimer car il est liée à au moins une facture, veuillez d\'abord supprimer toutes les factures liées');
            $this->redirect('admin/prescripteurs/edit'); 
        }
     }
     
       function delfiltre() {
        unset($_GET);
        $this->Session->setFlash('Filtre effacé');
        if ($this->Session->user('profil') == "admin") {
            $this->redirect('admin/prescripteurs/edit');
        }else {
            $this->redirect('agent/prescripteurs/edit');
        }
    }

function admin_detail($id){
        $this->loadModel('Prescripteur');
        $this->loadModel('User');
        $this->loadModel('Service');

        $d['services'] = $this->Service->get($this->request->data);

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['prescripteurs'] = $this->Prescripteur->findFirst(array(
            'conditions' => array('id'=>$id)
        ));
        
        if (empty($d['prescripteurs'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }
    
function chef_service_detail($id){
        $this->loadModel('Prescripteur');
        $this->loadModel('User');
        $this->loadModel('Service');

        $d['services'] = $this->Service->get($this->request->data);

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['prescripteurs'] = $this->Prescripteur->findFirst(array(
            'conditions' => array('id'=>$id)
        ));
        
        if (empty($d['prescripteurs'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }

function agent_detail($id){
        $this->loadModel('Prescripteur');
        $this->loadModel('User');
        $this->loadModel('Service');

        $d['services'] = $this->Service->get($this->request->data);

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['prescripteurs'] = $this->Prescripteur->findFirst(array(
            'conditions' => array('id'=>$id)
        ));
        
        if (empty($d['prescripteurs'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }
}
