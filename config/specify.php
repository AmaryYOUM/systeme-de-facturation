<?php
if ($this->request->prefix == 'admin') {
    if (!isset($this->request->controller)) {
        $this->redirect('users/auth_login');
    }else {
        $this->layout = 'admin';
        if (!$this->Session->isLogged() || $this->Session->user('profil') != 'admin') {
            $this->redirect('users/auth_login');
        }
    }
}elseif ($this->request->prefix == 'agent' && isset($this->request->controller)) {
    $this->layout = 'agent';
    if (!$this->Session->isLogged() || $this->Session->user('profil') != 'user') {
        $this->redirect('users/auth_login');
    }
}elseif(($this->request->prefix == 'chef_service' && isset($this->request->controller))){
    $this->layout = 'chef_service';
    if (!$this->Session->isLogged() || $this->Session->user('profil') != 'chef_service') {
        $this->redirect('users/auth_login');
    }
}elseif ($this->request->prefix == 'top_man' && isset($this->request->controller)) {
    $this->layout = 'top_management';
    if (!$this->Session->isLogged() || $this->Session->user('profil') != 'directeur') {
        $this->redirect('users/auth_login');
    }
}elseif ($this->request->prefix == 'auth') {
    $this->layout = 'login';    
}
?>