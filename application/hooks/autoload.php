<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function autoload() {
    spl_autoload_register(function($class) {
        if(strpos($class,'CI_') !== 0 && file_exists(APPPATH.'base/'.$class.'.php')) {
            require_once APPPATH . 'base/' . $class . '.php';
        }
    });
}