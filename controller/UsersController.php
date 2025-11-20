<?php
class UsersController extends Controller{

    /**
     * Permet d'éditer un utilisateur
     */ function admin_edit($id = null){
        $perPage = 30;

        $this->loadModel('User');
        $this->loadModel('Service');

        if ($this->Session->isLogged()) {
            $d['agent_login'] = $this->Session->user('login');
            $d['agent_id'] = $this->Session->user('id');
            $d['agent_prenom'] = $this->Session->user('prenom_user');
            $d['agent_nom'] = $this->Session->user('nom_user');
        }
        $d['id'] = '';
        if ($this->request->data) {
            $data = $this->request->data;
            $data->password = sha1($data->password);
            if($this->User->validates($this->request->data)){                
                $this->User->save($this->request->data);
                $this->Session->setFlash('agent modifié avec succès');    
                $this->redirect('admin/users/edit');
            }else {
                $this->Session->setFlash('Merci de corriger vos informations','error');    
            }

        }else {
            if ($id) {
                $this->request->data = $this->User->findFirst(array(
                    'conditions' => array('id'=>$id)
                ));
                $d['id'] = $id;
            }
        }

        $condition = array('id != 0');
        $d['filtre'] = '';

        if (!empty($_GET['profil'])) {
            $conduser = array('profil' => $_GET['profil']);

            $d['users'] = $this->User->find(array(
                'conditions' => $conduser,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['filtre'] = $_GET['profil'];
            $d['total_user'] = $this->User->findCount($conduser);
            $d['page'] = ceil($d['total_user'] / $perPage);
        }else {
            $d['users'] = $this->User->find(array(
                'conditions' => $condition,
                'limit' => ($perPage*($this->request->page-1)).','.$perPage,
                'order' => 'id'
            ));
            $d['total_user'] = $this->User->findCount($condition);
            $d['page'] = ceil($d['total_user'] / $perPage);
        }
        $d['services'] = $this->Service->find(array(
            'conditions' => $condition,
            'order' => 'id'
        ));
        $d['users_filtre'] = $this->User->find(array(
            'conditions' => array('profil != 0'),
            'group' => 'profil',
            'order' => 'id'
        ));

        $this->set($d);
     }

    /**
     * Permet de supprimer une facture
     */

    function admin_delete($id){
        $this->loadModel('User');
        $this->loadModel('Facture');

        $fact = $this->Facture->find(array(
         'conditions' => array('user_id'=>$id)
         ));

        if (empty($fact)) {
                $this->User->delete($id);
                $this->Session->setFlash('L\'agent a bien été supprimer');    
                $this->redirect('admin/users/edit');             
        }else {
            $this->Session->setFlash('L\'agent n\'a pas été supprimer car il est liée à au moins une facture, veuillez d\'abord supprimer toutes les factures liées');
            $this->redirect('admin/users/edit'); 
        }
     }



     function auth_login() {
        if ($this->request->data) {
            $data = $this->request->data;
            $data->password = sha1($data->password);
    
            $this->loadModel('User');
            
            // Vérification de l'utilisateur avec seulement le login
            $user = $this->User->findFirst(array(
                'conditions' => array('login' => $data->login)
            ));
    
            if (!empty($user)) {
                // Vérifier si l'utilisateur est temporairement bloqué
                if (!empty($user->locked_until) && strtotime($user->locked_until) > time()) {
                    $this->Session->setFlash('Votre compte est temporairement bloqué. Réessayez après ' . date('H:i:s', strtotime($user->locked_until)));
                    return;
                }
    
                // Vérifier le mot de passe
                if ($user->password === $data->password) {
                    // Connexion réussie : réinitialiser le compteur de tentatives et `locked_until`
                    $updateData = (object)[
                        'login' => $user->login,
                        'login_attempts' => 0,
                        'locked_until' => null,
                        'online' => 1 // Mettre à jour `online` à 1
                    ];
                    $this->User->saveonline($updateData);
    
                    // Enregistrer les informations de l'utilisateur dans la session
                    $this->Session->write('User', $user);
    
                    // Redirection en fonction du profil utilisateur
                    if ($this->Session->user('profil') == 'admin') {
                        $this->redirect('admin/dashboards/index');
                    } elseif ($this->Session->user('profil') == 'directeur') {
                        $this->redirect('top_man/dashboards/index');
                    } elseif ($this->Session->user('profil') == 'user') {
                        $this->redirect('agent/factures/edit');
                    } elseif ($this->Session->user('profil') == 'chef_service') {
                        if ($this->Session->user('service_id') == 0) {
                            $this->Session->setFlash('Aucun service ne vous a été attribué, veuillez vous rapprocher de votre administrateur.');
                        } else {
                            $this->redirect('chef_service/services/view/' . $this->Session->user('service_id'));
                        }
                    } else {
                        $this->redirect('');
                    }
                } else {
                    // Mauvais mot de passe : augmenter le compteur de tentatives
                    $attempts = $user->login_attempts + 1;
                    $locked_until = null;
    
                    // Mettre à jour le nombre de tentatives et éventuellement bloquer l'utilisateur
                    if ($attempts >= 5) { // Par exemple, 5 tentatives autorisées
                        $locked_until = date('Y-m-d H:i:s', strtotime('+15 minutes')); // Bloqué pendant 15 minutes
                        $this->Session->setFlash('Votre compte a été temporairement bloqué après trop de tentatives de connexion.');
                    }
    
                    // Mettre à jour les tentatives de connexion et le verrouillage de l'utilisateur
                    $updateData = (object)[
                        'login' => $user->login,
                        'login_attempts' => $attempts,
                        'locked_until' => $locked_until
                    ];
                    $this->User->saveonline($updateData);
    
                    $this->Session->setFlash('Mauvais identifiants. Il vous reste ' . (5 - $attempts) . ' tentatives.');
                }
            } else {
                $this->Session->setFlash('Aucun utilisateur trouvé avec cet identifiant.');
            }
    
            $this->request->data->password = '';
        }
    
        if ($this->Session->isLogged()) {
            if ($this->Session->user('profil') == 'admin') {
                $this->redirect('admin/dashboards/index');
            } elseif ($this->Session->user('profil') == 'directeur') {
                $this->redirect('top_man/dashboards/index');
            } elseif ($this->Session->user('profil') == 'user') {
                $this->redirect('agent/factures/edit');
            } elseif ($this->Session->user('profil') == 'chef_service') {
                if ($this->Session->user('service_id') == 0) {
                    $this->Session->setFlash('Aucun service ne vous a été attribué, veuillez vous rapprocher de votre administrateur.');
                } else {
                    $this->redirect('chef_service/services/view/' . $this->Session->user('service_id'));
                }
            } else {
                $this->redirect('');
            }
        }
    }
    

    function auth_majlogin() {
        if ($this->request->data) {
            $data = $this->request->data;
            $data->password = sha1($data->password);
    
            $this->loadModel('User');
            
            // Vérification de l'utilisateur avec seulement le login
            $user = $this->User->findFirst(array(
                'conditions' => array('login' => $data->login)
            ));
    
            if(!empty($user)) {
                    $updateData = (object)[
                        'login' => $data->login,
                        'maj_mdp' => 1 // Mettre à jour `maj_mdp` à 1
                    ];
                    $this->User->majlogin($updateData);
            }
            $this->request->data->password = '';
            $this->redirect('users/auth_login');
        }
       
    }


     function logout() {
        $this->loadModel('User');
        
        // Définir le fuseau horaire correct pour le Sénégal
        date_default_timezone_set('Africa/Dakar');
        
        // Obtenir l'identifiant de l'utilisateur depuis la session
        $userId = $this->Session->user('id');
        
        if ($userId) {
            // Créer un objet de données pour la mise à jour
            $updateData = (object)[
                'login' => $this->Session->user('login'),
                'online' => 0, // Définir 'online' à 0 pour déconnexion
                'last_logout' => date('Y-m-d H:i:s') // Ajouter l'heure de déconnexion
            ];
            
            // Mettre à jour l'état de l'utilisateur et sa déconnexion dans la base
            $this->User->saveonline($updateData);
        }
        
        // Détruire la session
        unset($_SESSION['User']);
        $this->Session->setFlash('Vous êtes déconnecté'); // Message de déconnexion
        $this->redirect('users/auth_login'); // Redirection vers la page de connexion
    }



    function delfiltre() {
        unset($_GET);
        $this->Session->setFlash('Filtre effacé');
        if ($this->Session->user('profil') == "admin") {
            $this->redirect('admin/users/edit');
        }else {
            $this->redirect('agent/users/edit');
        }
    }
}
