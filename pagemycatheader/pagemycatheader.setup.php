<?php
/* ====================
[BEGIN_COT_EXT]
Code=pagemycatheader
Name=Page My Custom Categories and Articles Header Template
Category=other
Description=Плагин для вывода пользовательского header.$location.tpl по выбранной родительской категории Page и всем её дочерним (включая статьи)
Version=2.3.0
Date=2025-11-29
Author=webitproff
Copyright=Copyright (c) webitproff 2025
Notes=Требует Cotonti Siena ≥0.9.26, PHP 8.4+
Auth_guests=R
Lock_guests=12345A
Auth_members=RW
Lock_members=12345A
Requires_modules=page
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
parentcat=01:string::user-guide:Код родительской категории Page (например user-guide)
[END_COT_EXT_CONFIG]
==================== */

/**
 * Page My Custom Categories and Articles Header Template for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: pagemycatheader.setup.php
 * Purpose: Registers metadata and configuration for the pagemycatheader plugin in the Cotonti admin panel.
 * Date: 2025-11-29
 * @package pagemycatheader
 * @version 2.3.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 https://github.com/webitproff/cot-pagemycatheader
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');


