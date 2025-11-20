<?php
class PrestationsController extends Controller{

    /**
     * Permet d'éditer une facture
     */

     function admin_edit($id = null){
        $perPage = 30;

        $this->loadModel('Service');
        $this->loadModel('Prestation');

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom');
            $d['agent_nom'] = $this->Session->user('nom');
        }
        $d['id'] = '';
        if ($this->request->data) {
            if($this->Prestation->validates($this->request->data)){                
                $this->Prestation->save($this->request->data);
                $this->Session->setFlash('La prestation a bien été modifier');    
                $this->redirect('admin/prestations/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->Prestation->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $d['filtre'] = '';

        if (!empty($_GET['service_id'])) {
            $condpresta = array('service_id' => $_GET['service_id']);

            $d['prestations'] = $this->Prestation->find(array(
                'conditions' => $condpresta,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['filtre'] = $_GET['service_id'];
            $d['total_prestation'] = $this->Prestation->findCount($condpresta);
            $d['page'] = ceil($d['total_prestation'] / $perPage);
        }else {
            $d['prestations'] = $this->Prestation->find(array(
                'conditions' => $condition,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['total_prestation'] = $this->Prestation->findCount($condition);
            $d['page'] = ceil($d['total_prestation'] / $perPage); 
        }

        $d['services'] = $this->Service->find(array(
            'conditions' => $condition,
            'order' => 'id',
        ));
        
        $this->set($d);
     }

     function chef_service_edit($id = null){
        $perPage = 30;

        $this->loadModel('Service');
        $this->loadModel('Prestation');

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['id'] = '';
        if ($this->request->data) {
            if($this->Prestation->validates($this->request->data)){                
                $this->Prestation->save($this->request->data);
                $this->Session->setFlash('La prestation a bien été modifier');    
                $this->redirect('chef_service/prestations/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->Prestation->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $condpresta = array('service_id' => $this->Session->user('service_id'));

            $d['prestations'] = $this->Prestation->find(array(
                'conditions' => $condpresta,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));

        $d['services'] = $this->Service->find(array(
            'conditions' => $condition,
            'order' => 'id',
        ));

        $d['total_prestation'] = $this->Prestation->findCount($condpresta);
        $d['page'] = ceil($d['total_prestation'] / $perPage);
        $this->set($d);
     }


    /**
     * Permet de supprimer une prestation
     */
    
    function admin_delete($id){
       $this->loadModel('Prestation');
       $this->loadModel('Facture');
       $fact = $this->Facture->find(array(
        'conditions' => array('prestation_id'=>$id)
        ));
        if (empty($fact)) {
            $this->Prestation->delete($id);
            $this->Session->setFlash('Prestation supprimé avec succès');    
            $this->redirect('admin/prestations/edit'); 
        }else {
            $this->Session->setFlash('Prestation non supprimé car elle est liée à au moins une facture, veuillez d\'abord supprimer toutes les factures liées');
            $this->redirect('admin/prestations/edit'); 
        } 
    }
    function chef_service_delete($id){
        $this->loadModel('Prestation');
        $this->loadModel('Facture');
        $fact = $this->Facture->find(array(
         'conditions' => array('prestation_id'=>$id)
         ));
         if (empty($fact)) {
             $this->Prestation->delete($id);
             $this->Session->setFlash('Prestation supprimé avec succès');    
             $this->redirect('chef_service/prestations/edit'); 
         }else {
             $this->Session->setFlash('Prestation non supprimé car elle est liée à au moins une facture, veuillez d\'abord supprimer toutes les factures liées');
             $this->redirect('chef_service/prestations/edit'); 
         } 
     }
    
    function delfiltre() {
        unset($_GET);
        $this->Session->setFlash('Filtre effacé');
        if ($this->Session->user('profil') == "admin") {
            $this->redirect('admin/prestations/edit');
        }else {
            $this->redirect('agent/prestations/edit');
        }
    }

}
