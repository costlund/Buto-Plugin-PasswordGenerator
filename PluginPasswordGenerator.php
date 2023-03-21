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
    $rs->set('length_32_all',       $this->random_str(32));
    $rs->set('length_64_all',       $this->random_str());
    $rs->set('length_8_lower',  $this->random_str(8, 'abcdefghijklmnopqrstuvwxyz'));
    /**
     * 
     */
    $page = wfDocument::getElementFromFolder(__DIR__, __FUNCTION__);
    $page->setByTag(array('data' => $rs->get()));
    $page = wfDocument::insertAdminLayout($this->settings, 1, $page);
    wfDocument::mergeLayout($page->get());
  }
  function random_str($length = 64, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
  }
}