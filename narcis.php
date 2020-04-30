<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Narcis extends Module
{

    public function __construct()
    {
        $this->name = 'narcis';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Narcis Chitescu';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); # to be discussed

        parent::__construct();

        $this->displayName = 'Narcis';
        $this->description = 'Narcis-Feeds';
        $this->confirmUninstall = 'Are you sure you want to uninstall this module?';
    }

    public function install()
    {

        if (Shop::isFeatureActive()) {
        	 Shop::setContext(Shop::CONTEXT_ALL);
   	     }

   	     return parent::install() &&  $this->createCustomTabLink();
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function createCustomTabLink()
    {
        $tab = new Tab;

        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[(int) $lang['id_lang']] = 'Products Export';
        }


        $tab->class_name = 'AdminFeeds';
        $tab->module = $this->name;
        $tab->id_parent = 0;
        $tab->add();

        return true;
    }

}
