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
 * KillSmarty module.
 *
 * This is the module-class which overloads the oxShopControl-class. To enable php-
 * rendering, we have to overwrite the oxShopControl::_process()-method.
 *
 * @package killsmarty
 */
class ksShopControl extends oxShopControl {

  /**
   * Overload of oxShopControl::_process().
   *
   * This method checks if there is corresponding .php-file to the .tpl file. If yes,
   * it renders this php file just using php (only including it) and not doing the snarty
   * thing. So we not disabling smarty at all, we just do php, if there is a php-file!
   *
   * @param string $sClass    Name of class
   * @param string $sFunction Name of function
   *
   * @return null
   */
  protected function _process( $sClass, $sFunction )
  {
      $myConfig = $this->getConfig();

      if ( !oxUtils::getInstance()->isSearchEngine() &&
           !( $this->isAdmin() || !$myConfig->getConfigParam( 'blLogging' ) ) ) {
          $this->_log( $sClass, $sFunction );
      }

      // starting resource monitor
      $this->_startMonitor();

      // creating current view object
      $oViewObject = oxNew( $sClass );

      // store this call
      $oViewObject->setClassName( $sClass );
      $oViewObject->setFncName( $sFunction );

      $myConfig->setActiveView( $oViewObject );

      // caching params ...
      $sOutput      = null;
      $blIsCached   = false;
      $blIsCachable = false;


      // init class
      $oViewObject->init();

      // executing user defined function
      $oViewObject->executeFunction( $oViewObject->getFncName() );

      // if no cache was stored before we should generate it
      if ( !$blIsCached ) {

          // render it
          $sTemplateName = $oViewObject->render();

          // Generate the Template-Filename
          $sTemplateFile = $myConfig->getTemplatePath( $sTemplateName, $this->isAdmin() ) ;

          // We check if tehre is a php-file of this template. If yes, we take this one and do php-rendering instead of smarty-rendering!
          $sPhpTemplateFile = str_replace('.tpl', '.php', $sTemplateFile);
          if(is_file($sPhpTemplateFile)) {
            $sTplEngine = 'php';
            $sTemplateFile = $sPhpTemplateFile;
          }
          else {
            $sTplEngine = 'smarty';
            // get Smarty is important here as it sets template directory correct
            $oSmarty = oxUtilsView::getInstance()->getSmarty();
          }

          // check if template dir exists
          if ( !file_exists( $sTemplateFile)) {
              $oEx = oxNew( 'oxSystemComponentException' );
              $oLang = oxLang::getInstance();
              $oEx->setMessage( sprintf($oLang->translateString( 'EXCEPTION_SYSTEMCOMPONENT_TEMPLATENOTFOUND', $oLang->getBaseLanguage() ), $sTemplateFile) );
              $oEx->setComponent( $sTemplateName );
              throw $oEx;
          }
          $aViewData = $oViewObject->getViewData();

          //Output processing. This is useful for modules. As sometimes you may want to process output manually.
          $oOutput = oxNew( 'oxoutput' );
          $aViewData = $oOutput->processViewArray( $aViewData, $oViewObject->getClassName() );
          $oViewObject->setViewData( $aViewData );

          //add all exceptions to display
          if ( ( $aErrors = oxSession::getVar( 'Errors' ) ) ) {
              oxUtilsView::getInstance()->passAllErrorsToView( $aViewData, $aErrors );

              // resetting errors after displaying them
              oxSession::setVar( 'Errors', array() );
          }

          if($sTplEngine == 'smarty') {
            foreach ( array_keys( $aViewData ) as $sViewName ) {
              $oSmarty->assign_by_ref( $sViewName, $aViewData[$sViewName] );
            }

            // passing current view object to smarty
            $oSmarty->oxobject = $oViewObject;

            $sOutput = $oSmarty->fetch( $sTemplateName, $oViewObject->getViewId() );
          }
          else {
            // Extract all view-vars to the symbol table
            extract($aViewData);
            // Create an instance of our Utils-class to call smarty-plugin-functions
            $_ = new ksUtilsView($this, $aViewData);

            // Start an output-buffer, include the template and write the buffered output to the $sOutput-var
            ob_start();
            require($sTemplateFile);
            $sOutput = ob_get_clean();
          }

          //Output processing - useful for modules as sometimes you may want to process output manually.
          $sOutput = $oOutput->process( $sOutput, $oViewObject->getClassName() );
          $sOutput = $oOutput->addVersionTags( $sOutput );
      }


      // show output
      //ob_Start("gzip");

      // #M1047 Firefox duplicated GET fix
      header("Content-Type: text/html; charset=".oxLang::getInstance()->translateString( 'charset' ));
      echo ( $sOutput );

      $myConfig->pageClose();

      // stopping resource monitor
      $this->_stopMonitor( $blIsCachable, $blIsCached, $sViewID, $oViewObject->getViewData() );
  }
}

?>