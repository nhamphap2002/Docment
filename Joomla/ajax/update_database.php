<?php

/*
  Created on : Jul 15, 2015, 9:37:44 AM
  Author     : Tran Trong Thang
  Email      : trantrongthang1207@gmail.com
 */
?
/*
 * Goi thu vien cua joomla
 */


/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// Set flag that this is a parent file.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

if (file_exists(dirname(__FILE__) . '/defines.php')) {
    include_once dirname(__FILE__) . '/defines.php';
}

if (!defined('_JDEFINES')) {
    define('JPATH_BASE', dirname(__FILE__));
    require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('site');

// Initialise the application.
$app->initialise();

// Mark afterIntialise in the profiler.
JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

// Route the application.
$app->route();

// Mark afterRoute in the profiler.
JDEBUG ? $_PROFILER->mark('afterRoute') : null;

// Dispatch the application.
$app->dispatch();

// Mark afterDispatch in the profiler.
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

/*
 * ket thuc goi thu vien joomla
 */
/*
 * Bat dau thuc hien cac cong viec cua minh o day
 * Co quyen su dung cac thu vien joomla roi
 */
$doc = JFactory::getDbo();
$query = 'ALTER TABLE `#__listings_companies` ADD `abn_can` TEXT NOT NULL AFTER `abn`;';
$doc->setQuery($query);
$doc->query();
exit();

