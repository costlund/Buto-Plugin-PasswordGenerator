<?php
class PluginPasswordGenerator{
  private $settings = null;
  function __construct() {
    wfPlugin::includeonce('wf/yml');
    $this->settings = wfPlugin::getModuleSettings(null, true);
    wfArray::set($GLOBALS, 'sys/layout_path', '/plugin/password/generator/layout');
  }
  public function page_generator(){
    /**
     * 
     */
    $rs = new PluginWfArray();
    $rs->set('length_8_l',           $this->random_str(8, 'l'));
    $rs->set('length_8_u',           $this->random_str(8, 'u'));
    $rs->set('length_8_d',           $this->random_str(8, 'd'));
    $rs->set('length_8_s',           $this->random_str(8, 's'));
    $rs->set('length_8_luds',       $this->random_str(8, 'luds'));
    $rs->set('length_16_luds',       $this->random_str(12, 'luds'));
    $rs->set('length_32_luds',       $this->random_str(32, 'luds'));
    $rs->set('length_64_luds',       $this->random_str(64, 'luds'));
    /**
     * 
     */
    $page = wfDocument::getElementFromFolder(__DIR__, __FUNCTION__);
    $page->setByTag(array('data' => $rs->get()));
    $page = wfDocument::insertAdminLayout($this->settings, 1, $page);
    wfDocument::mergeLayout($page->get());
  }
  private function random_str($length = 64, $keys = 'luds'){
    $keyspace = '';
    if(strstr($keys, 'l')){
      $keyspace .= 'abcdefghijklmnopqrstuvwxyz';
    }
    if(strstr($keys, 'u')){
      $keyspace .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if(strstr($keys, 'd')){
      $keyspace .= '0123456789';
    }
    if(strstr($keys, 's')){
      $keyspace .= "!()@";
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
  }
}