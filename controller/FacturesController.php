<?php
class FacturesController extends Controller{


    function admin_detail($num){

        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Service');
        $this->loadModel('Prestation');


        $d['users'] = $this->User->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['services'] = $this->Service->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['factures'] = $this->Facture->findFirst(array(
            'conditions' => array('num'=>$num)
        ));

        $d['fact'] = $this->Facture->find(array(
            'conditions' => array('num'=>$num)
        ));
        
        if (empty($d['factures'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }

    function agent_detail($num){
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Service');
        $this->loadModel('Prestation');

        $d['users'] = $this->User->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['services'] = $this->Service->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['factures'] = $this->Facture->findFirst(array(
            'conditions' => array('num'=>$num)
        ));

        $d['fact'] = $this->Facture->find(array(
            'conditions' => array('num'=>$num)
        ));
        
        if (empty($d['factures'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }

function chef_service_Fdetail($id){
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Service');
        $this->loadModel('Prestation');

        $d['users'] = $this->User->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['services'] = $this->Service->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        
        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['factures'] = $this->Facture->findFirst(array(
            'conditions' => array('id'=>$id)
        ));

        $d['fact'] = $this->Facture->find(array(
            'conditions' => array('id'=>$id)
        ));
        
        if (empty($d['factures'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }

     /**
     * Permet d'éditer une facture
     **/

function admin_edit($id = null){
    $perPage = 30;
    $this->loadModel('Facture');
    $this->loadModel('User');
    $this->loadModel('Patient');
    $this->loadModel('Service');
    $this->loadModel('Prestation');
    $this->loadModel('Prescripteur');
    $this->loadModel('Facturessupprimee');

    $d['users'] = $this->User->get($this->request->data);

    if ($this->Session->isLogged()) {
        $d['agent_login'] = $this->Session->user('login');
        $d['agent_id'] = $this->Session->user('id');
        $d['agent_prenom'] = $this->Session->user('prenom_user');
        $d['agent_nom'] = $this->Session->user('nom_user');
    }

    // Insertion ou modification de facture
    $d['id'] = '';
    $d['prestat_id'] = '';
    
    if ($this->request->data) {
        $prestations = $this->request->data->prestation_id;
        $montants = $this->request->data->montant;

        if (count($prestations) === count($montants)) {
            $numero_facture = "Fact-N°" . $this->Facture->getNextNumeroFacture();
            $save_ok = true;

            foreach ($prestations as $k => $prestationId) {
                $this->request->data->prestation_id = $prestationId;
                $this->request->data->montant = $montants[$k];
                $this->request->data->num = $numero_facture;

                if ($this->Facture->validates($this->request->data)) {
                    $this->Facture->sauvegarder($this->request->data);
                } else {
                    $save_ok = false;
                    $this->Session->setFlash('Merci de corriger vos informations', 'error');
                }
            }
            if ($save_ok) {
                $this->Facture->incrementerNumeroFacture();
                $this->Session->setFlash('La facture a bien été modifiée');
                $this->redirect('admin/factures/edit');
            }
        } else {
            $this->Session->setFlash('Le nombre de prestations et de montants ne correspond pas', 'error');
        }
    } else {
        if ($id) {
            $this->request->data = $this->Facture->findFirst(array(
                'conditions' => array('id' => $id)
            ));
            $d['id'] = $id;
        }
    }

$supprimees = $this->Facturessupprimee->find(array(
    'fields' => 'numero_facture'
));

$liste_numeros = array_map(function($s) {
    return $s->numero_facture;
}, $supprimees);

$clause_exclusion = '';
if (!empty($liste_numeros)) {
    $in_clause = "'" . implode("','", $liste_numeros) . "'";
    $clause_exclusion = "num NOT IN ($in_clause)";
}else{
    $clause_exclusion = "id != 0";
}

    $condition = "id != 0";

    // Filtrage par date
    $d['debut'] = '';
    $d['fin'] = '';
    $d['patient_id'] = '';
    $d['service_id'] = '';
if (!empty($_GET['debut']) && !empty($_GET['fin'])) {
    $clause_date = 'date_creation >= "' . $_GET['debut'] . '" AND date_creation <= "' . $_GET['fin'] . '"';
    // Combine les deux conditions
    if (!empty($clause_exclusion)) {
        $condfact = $clause_date . ' AND ' . $clause_exclusion;
    } else {
        $condfact = $clause_date;
    }
    $d['factures'] = $this->Facture->find(array(
        'conditions' => $condfact,
        'group' => 'num',
        'limit' => ($perPage * ($this->request->page - 1)) . ',' . $perPage,
        'order' => 'id'
    ));
    $d['debut'] = $_GET['debut'];
    $d['fin'] = $_GET['fin'];
    $d['total_facture'] = $this->Facture->CountFact($condfact);
    $d['page'] = ceil($d['total_facture'] / $perPage);
} else {
    $d['factures'] = $this->Facture->find(array(
        'conditions' => $clause_exclusion,
        'group' => 'num',
        'limit' => ($perPage * ($this->request->page - 1)) . ',' . $perPage,
        'order' => 'id'
    ));
    $d['total_facture'] = $this->Facture->CountFact($clause_exclusion);
    $d['page'] = ceil($d['total_facture'] / $perPage);
    }
    // Filtrage par service
    if (!empty($_GET['service_id'])) {
        $d['prestat'] = $this->Prestation->find(array(
            'conditions' => array('service_id' => $_GET['service_id'])
        ));
        $d['serv'] = $_GET['service_id'];
    }
    $d['patients'] = $this->Patient->find(array(
        'conditions' => $condition,
        'order' => 'id',
    ));
    $d['prescripteurs'] = $this->Prescripteur->find(array(
        'conditions' => $condition,
        'order' => 'id',
    ));
    $d['services'] = $this->Service->find(array(
        'conditions' => $condition,
        'order' => 'id',
    ));
    $d['prestations'] = $this->Prestation->find_prestat(array(
        'conditions' => $condition,
        'order' => 'intitule_prestat',
    ));

    // Pour affichage uniquement
    $d['num_facture'] = $this->Facture->getNextNumeroFacture();
    $this->set($d);
}

function agent_edit($id = null){
    $perPage = 30;
    $this->loadModel('Facture');
    $this->loadModel('User');
    $this->loadModel('Patient');
    $this->loadModel('Service');
    $this->loadModel('Prestation');
    $this->loadModel('Prescripteur');
    $this->loadModel('Facturessupprimee');

    $d['users'] = $this->User->get($this->request->data);

    if ($this->Session->isLogged()) {
        $d['agent_login'] = $this->Session->user('login');
        $d['agent_id'] = $this->Session->user('id');
        $d['agent_prenom'] = $this->Session->user('prenom_user');
        $d['agent_nom'] = $this->Session->user('nom_user');
    }

    $d['id'] = '';
    $d['prestat_id'] = '';

    if ($this->request->data) {
        $prestations = $this->request->data->prestation_id;
        $montants = $this->request->data->montant;

        if (count($prestations) === count($montants)) {
            // Récupère le numéro de facture une seule fois
            $numero_facture = "Fact-N°".$this->Facture->getNextNumeroFacture();
            $save_ok = true;

            foreach ($prestations as $k => $prestationId) {
                $this->request->data->prestation_id = $prestationId;
                $this->request->data->montant = $montants[$k];
                $this->request->data->num = $numero_facture;

                if ($this->Facture->validates($this->request->data)) {
                    $this->Facture->sauvegarder($this->request->data);
                } else {
                    $save_ok = false;
                    $this->Session->setFlash('Merci de corriger vos informations', 'error');
                }
            }

            if ($save_ok) {
                // Incrémente la valeur uniquement si tout a été sauvegardé
                $this->Facture->incrementerNumeroFacture();
                $this->Session->setFlash('La facture a bien été modifiée');
                $this->redirect('agent/factures/edit');
            }

        } else {
            $this->Session->setFlash('Le nombre de prestations et de montants ne correspond pas', 'error');
        }
    } else {
        if ($id) {
            $this->request->data = $this->Facture->findFirst(array(
                'conditions' => array('id' => $id)
            ));
            $d['id'] = $id;
        }
    }

    // Affichage factures
    $condition = array('id != 0');
    $d['debut']='';
    $d['fin']='';
    $d['patient_id']='';
    $d['service_id']='';

$supprimees = $this->Facturessupprimee->find(array(
    'fields' => 'numero_facture'
));

$liste_numeros = array_map(function($s) {
    return $s->numero_facture;
}, $supprimees);

$clause_exclusion = '';
if (!empty($liste_numeros)) {
    $in_clause = "'" . implode("','", $liste_numeros) . "'";
    $clause_exclusion = "num NOT IN ($in_clause)";
}else{
    $clause_exclusion = "id != 0";
}

    if (!empty($_GET['debut']) && !empty($_GET['fin'])) {
        $clause_date = 'date_creation >= "' . $_GET['debut'] . '" AND date_creation <= "' . $_GET['fin'] . '"';
    
        // Combine les deux conditions
        if (!empty($clause_exclusion)) {
            $condfact = $clause_date . ' AND ' . $clause_exclusion;
        } else {
            $condfact = $clause_date;
        }
    
        $d['factures'] = $this->Facture->find(array(
            'conditions' => $condfact,
            'group' => 'num',
            'limit' => ($perPage*($this->request->page-1)).','.$perPage,
            'order' => 'id'
        ));
        $d['debut'] = $_GET['debut'];
        $d['fin'] = $_GET['fin'];
        $d['sum_fact'] = $this->Facture->sum($condfact);
        $d['total_facture'] = $this->Facture->CountFact($condfact);
        $d['page'] = ceil($d['total_facture'] / $perPage);
    } else {

        $d['factures'] = $this->Facture->find(array(
            'conditions' => $clause_exclusion,
            'group' => 'num',
            'limit' => ($perPage*($this->request->page-1)).','.$perPage,
            'order' => 'id'
        ));
        $d['sum_fact'] = $this->Facture->sum($clause_exclusion);
        $d['total_facture'] = $this->Facture->CountFact($clause_exclusion);
        $d['page'] = ceil($d['total_facture'] / $perPage);
        
    }

    if (!empty($_GET['service_id'])) {
        $d['prestat'] = $this->Prestation->find(array(
            'conditions' => array('service_id' => $_GET['service_id'])
        ));
        $d['serv'] = $_GET['service_id'];
    }

    $d['prescripteurs'] = $this->Prescripteur->find(array(
        'conditions' => $condition,
        'order' => 'id',
    ));
    $d['patients'] = $this->Patient->find(array(
        'conditions' => $condition,
        'order' => 'id',
    ));
    $d['services'] = $this->Service->find(array(
        'conditions' => $condition,
        'order' => 'id',
    ));
    $d['prestations'] = $this->Prestation->find_prestat(array(
        'conditions' => $condition,
        'order' => 'intitule_prestat',
    ));

    // Pour affichage uniquement
    $d['num_facture'] = $this->Facture->getNextNumeroFacture();

    $this->set($d);
}

     function export(){
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Service');
        $this->loadModel('Prestation');
        $this->loadModel('Prescripteur');
        $this->loadModel('Facturessupprimee');

        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);
        $d['services'] = $this->Service->get($this->request->data);
        $d['prescripteurs'] = $this->Prescripteur->get($this->request->data);

        $d['output'] = "";

        $d['debut']='';
        $d['fin']='';

        $supprimees = $this->Facturessupprimee->find(array(
            'fields' => 'numero_facture'
        ));
        
        $liste_numeros = array_map(function($s) {
            return $s->numero_facture;
        }, $supprimees);
        
        $clause_exclusion = '';
        if (!empty($liste_numeros)) {
            $in_clause = "'" . implode("','", $liste_numeros) . "'";
            $clause_exclusion = "num NOT IN ($in_clause)";
        }else{
            $clause_exclusion = "id != 0";
        }
        
        if (!empty($_GET['debut']) && !empty($_GET['fin'])) {
                $clause_date = 'date_creation >= "' . $_GET['debut'] . '" AND date_creation <= "' . $_GET['fin'] . '"';
                // Combine les deux conditions
                if (!empty($clause_exclusion)) {
                    $condfact = $clause_date . ' AND ' . $clause_exclusion;
                } else {
                    $condfact = $clause_date;
                }
                $d['factures'] = $this->Facture->find(array(
                    'conditions' => $condfact,
                    'order_asc' => 'id'
                ));
                $d['debut'] = $_GET['debut'];
                $d['fin'] = $_GET['fin'];
            }else {
            $d['factures'] = $this->Facture->find(array(
                'conditions' => $clause_exclusion,
                'order_asc' => 'id'
            ));
        }
        $this->set($d);
     }

     function agent_modif($id = null){
        $this->loadModel('Facture');
        $this->loadModel('User');
        $this->loadModel('Patient');
        $this->loadModel('Service');
        $this->loadModel('Prestation');

        $d['users'] = $this->User->get($this->request->data);
        $d['prestations'] = $this->Prestation->get($this->request->data);
        $d['patients'] = $this->Patient->get($this->request->data);


        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom');
            $d['agent_nom'] = $this->Session->user('nom');
        }
        $d['id'] = '';
        if ($this->request->data) {
            if($this->Facture->validates($this->request->data)){
                $this->Facture->sauvegarder($this->request->data);  
                $this->Session->setFlash('La facture a bien été modifier');    
                $this->redirect('agent/factures/edit');            
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');
            }
        
        }else {
            if ($id) {
                $this->request->data = $this->Facture->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }       
        $this->set($d);
     }
     
     function admin_corbeille(){
         $perPage = 30;
         $condition = "id != 0";

            $this->loadModel('Facture');
            $this->loadModel('User');
            $this->loadModel('Patient');
            $this->loadModel('Service');
            $this->loadModel('Prestation');
            $this->loadModel('Prescripteur');
            $this->loadModel('Facturessupprimee');
        
            $d['users'] = $this->User->get($this->request->data);
        
            if ($this->Session->isLogged()) {
                $d['agent_login'] = $this->Session->user('login');
                $d['agent_id'] = $this->Session->user('id');
                $d['agent_prenom'] = $this->Session->user('prenom_user');
                $d['agent_nom'] = $this->Session->user('nom_user');
            }
                        
            $supprimees = $this->Facturessupprimee->find(array(
            'conditions' => $condition,
            'fields' => 'numero_facture'
            ));
            $liste_numeros = array_map(function($s) {
            return $s->numero_facture;
            }, $supprimees);
            
            $clause_exclusion = '';
            if (!empty($liste_numeros)) {
                $in_clause = "'" . implode("','", $liste_numeros) . "'";
                $clause_exclusion = "num IN ($in_clause)";
            }else{
                $clause_exclusion = "id != 0";
            }
            
            $d['factures'] = $this->Facture->find(array(
                'conditions' => $clause_exclusion,
                'group' => 'num',
                'limit' => ($perPage * ($this->request->page - 1)) . ',' . $perPage,
                'order' => 'id'
            ));
            $d['prescripteurs'] = $this->Prescripteur->find(array(
            'conditions' => $condition,
            'order' => 'id',
            ));
            $d['patients'] = $this->Patient->find(array(
                'conditions' => $condition,
                'order' => 'id',
            ));
            $d['services'] = $this->Service->find(array(
                'conditions' => $condition,
                'order' => 'id',
            ));
            $d['prestations'] = $this->Prestation->find_prestat(array(
                'conditions' => $condition,
                'order' => 'intitule_prestat',
            ));
            $d['total_facture'] = $this->Facture->CountFact($clause_exclusion);
            $d['page'] = ceil($d['total_facture'] / $perPage);
                $this->set($d);
     }
    
    /**
     * Permet de supprimer une facture
*/
    function admin_delete_definitive($numero) {
        $this->loadModel('Facture');
        
        // Supprimer tous les éléments liés à ce numéro de facture
        $this->Facture->deleteByNumeroFacture($numero);
    
        // Ajouter un message flash pour informer l'utilisateur
        $this->Session->setFlash('La facture et tous ses éléments associés ont bien été supprimés.');
    
        // Redirection après la suppression
        $this->redirect('admin/dashboards/index');        
    }
     
     
    function admin_delete($numero) {
    $this->loadModel('Facture');
    $this->loadModel('Facturessupprimee');

    // Vérifie si la facture existe
    $facture = $this->Facture->findFirst([
        'conditions' => ['num' => $numero]
    ]);

    if (!$facture) {
        $this->Session->setFlash('Facture introuvable.', 'danger');
        $this->redirect('admin/factures/edit');
    }

    // Vérifie si la facture est déjà supprimée
    $exist = $this->Facturessupprimee->findFirst([
        'conditions' => ['numero_facture' => $numero]
    ]);

    if (!$exist) {
        // Sauvegarder l'entrée dans la table des factures supprimées
        $this->Facturessupprimee->save([
            'numero_facture' => $numero,
            'date_suppression' => date('Y-m-d H:i:s'),
            'user_id' => $this->Session->user('id') // Si tu stockes l'utilisateur
        ]);
    }

    $this->Session->setFlash("La facture a été marquée comme supprimée.");
    $this->redirect('admin/factures/edit');
}


    function delfiltre() {
        unset($_GET);
        $this->Session->setFlash('Filtre effacé');
        if ($this->Session->user('profil') == "admin") {
            $this->redirect('admin/factures/edit');
        }else {
            $this->redirect('agent/factures/edit');
        }
    }
    
}