<?php
class Form{

    public $controller;
    public $errors;

    public function __construct($controller){
        $this->controller = $controller;
    }

    public function input($name,$label,$options = array(), $css=null){
        $error = false;
        $classError = '';
        if (isset($this->errors[$name])) {
            $error = $this->errors[$name];
            $classError = ' error';
        }
        if (!isset($this->controller->request->data->$name)) {
            $value = '';
        }else {
            $value = $this->controller->request->data->$name;
        }

        if ($label == 'hidden'){
            return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
        }
        elseif ($label == 'corriger') {
            return '<input type="hidden" name="'.$name.'" value="0"><input type="checkbox" name="'.$name.'" value="1" '.(empty($value)?'':'checked').'>';
        }
        
        if ($css == 'label-color'){
            $html = '<div class="clearfix'.$classError.'" >
            <label style="color:white" for="input'.$name.'">'.$label.'</label>
            <div class="form-control">';
        }elseif ($css == 'input-class'){
            $html =  '<div class="clearfix'.$classError.'" >
            <div class="input">';
        }else {
            $html = '<div class="clearfix'.$classError.'" >
                 <label for="input'.$name.'">'.$label.'</label>
                 <div class="input">';
        }
        $attr = ' ';
        foreach ($options as $k => $v) {
            if ($k != 'type') {
                $attr .= " $k=\"$v\"";
            }
        }
        
        if (!isset($options['type'])){
            $html .= '<input style="height: 25px;" type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }elseif ($label == 'online') {
            return '<input type="hidden" name="'.$name.'" value="0"><input type="hidden"  name="'.$name.'" value="1" '.(empty($value)?'':'checked').'>';
        }elseif ($options['type'] == 'input-class'){
            $html .= '<input style="height: 35px; width: 300px;" class="form-control" type="text" id="input'.$name.'" placeholder="'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }elseif ($options['type'] == 'number') {
            $html .= '<input style="height: 25px;" type="number" id="input'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }elseif ($options['type'] == 'textarea') {
            $html .= '<textarea id="input'.$name.'" name="'.$name.'" '.$attr.'>'.$value.'</textarea>';
        }elseif ($options['type'] == 'passwordlogin') {
            $html .= '<input style="height: 35px; width: 300px;"  class="form-control" type="password" id="input'.$name.'" placeholder="'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }
        elseif ($options['type'] == 'password') {
            $html .= '<input style="height: 25px;" type="password" id="input'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }elseif ($options['type'] == 'date') {
            $html .= '<input style="height: 25px;" type="date" id="input'.$name.'" name="'.$name.'" value="'.$value.'" '.$attr.'>';
        }
        if ($error) {
            $html .= '<span class="help-inline">'.$error.'</span>';
        }
        $html .= '</div></div>';
        return $html;
    }
}