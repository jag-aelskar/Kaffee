<?php

/**
 * Addonlist
 * @package redaxo4
 * @version svn:$Id$
 */

// ----------------- addons
unset($REX['ADDON']);
$REX['ADDON'] = array();

// ----------------- DONT EDIT BELOW THIS
// --- DYN
$REX['ADDON']['install']['be_dashboard'] = '0';
$REX['ADDON']['status']['be_dashboard'] = '0';

$REX['ADDON']['install']['be_search'] = '1';
$REX['ADDON']['status']['be_search'] = '1';

$REX['ADDON']['install']['be_style'] = '1';
$REX['ADDON']['status']['be_style'] = '1';

$REX['ADDON']['install']['cronjob'] = '0';
$REX['ADDON']['status']['cronjob'] = '0';

$REX['ADDON']['install']['image_manager'] = '1';
$REX['ADDON']['status']['image_manager'] = '1';

$REX['ADDON']['install']['image_resize'] = '0';
$REX['ADDON']['status']['image_resize'] = '0';

$REX['ADDON']['install']['import_export'] = '1';
$REX['ADDON']['status']['import_export'] = '1';

$REX['ADDON']['install']['metainfo'] = '1';
$REX['ADDON']['status']['metainfo'] = '1';

$REX['ADDON']['install']['phpmailer'] = '1';
$REX['ADDON']['status']['phpmailer'] = '1';

$REX['ADDON']['install']['rexsale'] = '1';
$REX['ADDON']['status']['rexsale'] = '1';

$REX['ADDON']['install']['rexsmarty'] = '1';
$REX['ADDON']['status']['rexsmarty'] = '1';

$REX['ADDON']['install']['textile'] = '0';
$REX['ADDON']['status']['textile'] = '0';

$REX['ADDON']['install']['tinymce'] = '0';
$REX['ADDON']['status']['tinymce'] = '0';

$REX['ADDON']['install']['url_rewrite'] = '1';
$REX['ADDON']['status']['url_rewrite'] = '1';

$REX['ADDON']['install']['version'] = '0';
$REX['ADDON']['status']['version'] = '0';
// --- /DYN
// ----------------- /DONT EDIT BELOW THIS

require $REX['INCLUDE_PATH']. '/plugins.inc.php';

foreach(OOAddon::getAvailableAddons() as $addonName)
{
  $addonConfig = rex_addons_folder($addonName). 'config.inc.php';
  if(file_exists($addonConfig))
  {
    require $addonConfig;
  }
  
  foreach(OOPlugin::getAvailablePlugins($addonName) as $pluginName)
  {
    $pluginConfig = rex_plugins_folder($addonName, $pluginName). 'config.inc.php';
    if(file_exists($pluginConfig))
    {
      rex_pluginManager::addon2plugin($addonName, $pluginName, $pluginConfig);
    }
  }
}

// ----- all addons configs included
rex_register_extension_point('ADDONS_INCLUDED');