<?php
/**
 *    This file is part of the "KillSmarty"-module.
 *
 *    The KillSmarty-module gives you the ability to decide, if you want to render a
 *    template using smarty or just php!
 *
 *    HowTo:
 *    The module checks, if there is a .php-template-file next to the .tpl-file. If
 *    there is one, it'll be rendered/included instead of rendering the .tpl-
 *    file with the smarty-engine.
 *    For example you want to render the startpage with php. The startpage is generated
 *    using the view "start" and the template "start.tpl". So now you just copy the
 *    "start.tpl" to "start.php". The KillSmarty-module will recognize this and renders
 *    this .php-file instead of using smarty with the original .tpl-file!
 *    It's easy as it can be! :)
 *
 *    Why not killing Smarty completly?
 *    Because the admin interface also uses smarty and who wants to redesign the admin
 *    interface, huh? ;)
 *
 * @link http://andy-hofmann.com
 * @package killsmarty
 * @copyright (C) Andreas Hofmann 2010, ich@andy-hofmann.com
 * @version 1.0
 */

/**
 * KillSmarty utils-class and wrapper for OXID-smarty-functions.
 *
 * Unfortunately we need this class, because OXID has some registered smarty-functions.
 * We make use of the Magic-Method ::__call(), and implement some smarty-wrappers.
 *
 * @package killsmarty
 */
class ksUtilsView {

  /**
   * Variable holding the view-object passed to this instance.
   * @var object
   */
  private $_oView;

  /**
   * Variable storing a copy of the config-object.
   * @var object
   */
  private $_oConfig;

  /**
   * Instance of a smarty-object. We need it for generating the paths. I don't want to
   * do this by myself :)
   * @var object
   */
  private $_oSmarty;

  /**
   * This variable holds all vars assigned by the custom functions. It's a part of the
   * smarty-fake we are doing.
   * @var array
   */
  public $_tpl_vars = array();

  /**
   * Class-constructor, initializing some class-properties.
   *
   * It sets the passed view-object and viewData and creates instances of smarty and
   * the config-object.
   *
   * @param object $oView     The current processed view
   * @param array $aArguments Array with the current view-data
   *
   * @return null
   */
  public function __construct($oView, $aViewData) {
    $this->_oView = $oView;
    $this->_oConfig = $this->_oView->getConfig();
    $this->_oSmarty = oxUtilsView::getInstance()->getSmarty();
    $this->_tpl_vars = $aViewData;
  }

  /**
   * Wrapper for the smarty-functions.
   *
   * Here we catch all methods called on this object out of the templates. We try
   * to include the corresponding file for the called method and execute it if
   * it's present. Currently smarty-custom-functions and -modifiers are supported.
   *
   * We also pass this instance to the smarty functions as a fake of a smarty-object.
   * For example we catch variable-assignents and sub-rendering done in the custom
   * functions.
   *
   * @param string $sName     Name of the function/modifier/etc
   * @param array $aArguments The arguments passed to the function
   *
   * @return mixed The return of the custom function or false if no function was found
   */
  public function __call($sName, $aArguments) {

    $types = array('function', 'modifier', 'insert');

    foreach($types as $type) {
      // Do we have a smarty-function with this name?
      $sSmartyFunc = "smarty_{$type}_{$sName}";
      // If the function is not registered/included already
      if(!function_exists($sSmartyFunc)) {
        $sSmartyFile = $this->_oSmarty->_get_plugin_filepath($type, $sName);
        // Include the file holding the function
        if(is_file($sSmartyFile)) {
          require_once($sSmartyFile);
        }
      }
      // Do we finally know the function? If yes, execute it!
      if(function_exists($sSmartyFunc)) {
        return $sSmartyFunc($aArguments[0], $this);
      }
    }

    return false;
  }

  /**
   * Wrapper for the smarty::assign()-method.
   *
   * We are faking a smarty object, because we need to catch this assign()-calls done
   * within the custom-functions. We saving this vars in our own var and not doing
   * smarty stuff.
   *
   * @param string $sName Name of the variable
   * @param mixed $mVal   Value of teh variable
   *
   * @return null
   */
  public function assign($sName, $mVal) {
    $this->_tpl_vars[$sName] = $mVal;
  }

  /**
   * Wrapper for the smarty::clear_assign()-method.
   *
   * Delete the named variable from our var-table.
   *
   * @param string $sName Name of the variable
   *
   * @return null
   */
  public function clear_assign($sName) {
    unset($this->_tpl_vars[$sName]);
  }

  /**
   * Wrapper for the smarty::fetch()-method.
   *
   * One of the important things! Stop doing smarty stuff and just include the template.
   * Before that we do an extract() which exports all array-values to the global var-
   * table, which is the same as declaring them.
   *
   * @param string $sFile The filename to render/include
   *
   * @return null
   */
  public function fetch($sFile) {

    /* There is a registered smarty-ressource "ox:" that gets the content from the
       $smarty->oxidcache property. This ressource is handled by the function ox_get_template() */
    if(substr($sFile, 0, 3) == 'ox:' && isset($this->oxidcache) && !empty($this->oxidcache)) {
      ox_get_template('', $sTplSource, $this);
      eval('?>' . $sTplSource);
    }
    else {
      $sTemplateFile = $this->_oConfig->getTemplatePath($sFile, $this->_oView->isAdmin()) ;
      $sTemplateFile = !empty($sTemplateFile) ? $sTemplateFile : $sFile;

      extract($this->_tpl_vars);
      include($sTemplateFile);
    }
  }

  /**
   * Wrapper for the smarty::_get_plugin_filepath()-method.
   *
   * We just wrap this method. It returns the full path to the plugin.
   *
   * @param string $sType Type of wich path we want (function, modifier, etc.)
   * @param string $sName Name of the function/modifier/etc.
   *
   * @return string The full path to the plugin
   */
  public function _get_plugin_filepath($sType, $sName) {
    return $this->_oSmarty->_get_plugin_filepath($sType, $sName);
  }

  /**
   * Shortcut/alias for ::oxmultilang().
   *
   * Idea taken from cakePHP. There the function __() is doing the translation! It's
   * shorter and in 95% of all cases you only need the first param. So this shortcur
   * makes the view more tidy.
   *
   * @param string $sIdent  The Language identifier you want the translation for
   * @param string $aParams Additional parameters
   *
   * @return string Translated string for the given identifier
   */
  public function __($sIdent, $aParams = array()) {
    return $this->oxmultilang(array_merge(
      array('ident' => $sIdent),
      $aParams
    ));
  }

  /**
   * Shortcut/alias for ::oxgetseourl().
   *
   * Idea taken from cakePHP. There the function __() is doing translation! It's shorter and in
   * 95% of all cases you only need the first param. So this shortcur makes the view
   * more tidy.
   *
   * @param string $sIdent  The Language identifier you want the translation for
   * @param string $aParams Additional parameters
   *
   * @return string Generated SEO-URL
   */
  public function _s($sIdent, $aParams = array()) {
    return $this->oxgetseourl(array_merge(
      array('ident' => $sIdent),
      $aParams
    ));
  }
}

?>