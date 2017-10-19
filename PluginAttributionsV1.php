<?php
/**
 * Plugin to show attributions from plugins.
 * Checks for file /plugin/_/_/config/attribute.yml.
 * Good if one need to attribute others.
 */
class PluginAttributionsV1{
  /**
   * Widget on a attribution page.
   */
  public function widget_render($data){
    /**
     * 
     */
    wfPlugin::includeonce('wf/array');
    $plugins = wfPlugin::getPluginForTheme();
    /**
     * Checks for attribute.yml files.
     */
    foreach ($plugins->get() as $key => $value) {
      foreach ($value as $key2 => $value2) {
        if(wfFilesystem::fileExist(wfArray::get($GLOBALS, 'sys/app_dir').'/plugin/'.$key.'/'.$key2.'/config/attribute.yml')){
          $attribute = wfSettings::getSettings('/plugin/'.$key.'/'.$key2.'/config/attribute.yml', 'content');
          $plugins->set("$key/$key2/attribute", $attribute);
        }
      }
    }
    /**
     * Create element and render.
     */
    $element = array();
    $element[] = wfDocument::createHtmlElement('h1', 'Attributions');
    foreach ($plugins->get() as $key => $value) {
      foreach ($value as $key2 => $value2) {
        if(isset($value2['attribute'])){
          $element[] = wfDocument::createHtmlElement('h2', $value2['name']);
          $element[] = wfDocument::createHtmlElement('div', $value2['attribute']);
        }
      }
    }
    wfDocument::renderElement($element);
  }
}