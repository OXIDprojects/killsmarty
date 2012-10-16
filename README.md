killsmarty
==========

The KillSmarty-module gives you the ability to decide, if you want to render a template using smarty or just php! 

Originally registered: 2010-02-25 by Andreas Hofmann on former OXID forge.

﻿/**
 *    This file is part of the "KillSmarty"-module.
 *
 *    The KillSmarty-module gives you the ability to decide, if you want to render a
 *    template using smarty or just php!
 *
 * @link http://andy-hofmann.com
 * @package killsmarty
 * @copyright (C) Andreas Hofmann 2010, ich@andy-hofmann.com
 * @version 1.0
 */

## Setup: ##
Copy both, the directory "killsmarty" and the file "ksutilsview.php", to your modules
directory.
Now open the adminpanel of your OXIDshop and go to:
Stammdaten => Grundeinstellungen => System => Module
Copy this to the field "Installierte Module in Ihrem eShop":

 oxshopcontrol => killsmarty/ksshopcontrol

And this to "Additional util module":

 killksutilsview.php


That's it! Now you can start creating .php-files instead of the .tpl-files! :)

HowTo:
======
To render a page just using php and not smarty, just create a file with the same name
but with the ending .php. So if you want to render the startpage with php, copy the
start.tpl to start.php. OXID will now render/include this php-file!
In this php-Files you have access to all assigned-smarty vars, like $oView. You also
have an instance of the ksUtilsView-class, identified by the variable "$_". This
utilclass gives you access to the oxid-smarty functions (plugins), for example
 "oxmultilang" or "oxgetseourl". I've also created shortcuts for this two functions:
__($sIdent, $aParams = array()) => shortcut for oxmultilang
_s($sIdent, $aParams = array()) => shortcut for oxgetseourl

You should take a look at my example-templates for getting a better understanding.
I've started to convert the startpage of the shop, but couldn't finish it.

What now?
I couldn't finish this project yet, because my company decided to not use OXID, so I
can't do it at work. I'll continue working on it, if I have some free time, so stay
tuned ;)
The utilclass should be able to wrap all smarty-plugin-functions due the use of the
magic method __call(). But maybe it will not work sometimes, so you have to take a
deeper look at it.