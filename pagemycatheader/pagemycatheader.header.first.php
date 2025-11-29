<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.first
[END_COT_EXT]
==================== */

// Этот плагин подключаясь к "header.first" будет выполняться в самом начале формирования заголовка сайта
// Защита от прямого доступа — если кто-то откроет файл напрямую, сайт не упадёт
defined('COT_CODE') or die('Wrong URL.');

// Подключаем основной файл плагина (pagemycatheader.functions.php), чтобы были доступны функции и настройки
// У тебя файл функций лежит в корне плагина, поэтому путь именно такой
require_once cot_incfile('pagemycatheader', 'plug');

// Получаем из настроек плагина код родительской категории (например, "user-guide")
// Если настройка не задана — берём пустую строку
$parentCat = trim((string)(Cot::$cfg['plugin']['pagemycatheader']['parentcat'] ?? ''));

// Если в админке ничего не указано — выходим молча, плагин ничего не делает
if ($parentCat === '') return;

// Формируем имя location, которое поймёт Cotonti при выборе шаблона header.$location.tpl
// Например: page.user-guide → будет искаться header.page.user-guide.tpl
$targetLocation = 'page.' . $parentCat;

// ====================================================================
// САМОЕ ГЛАВНОЕ И ЕДИНСТВЕННО РАБОЧЕЕ РЕШЕНИЕ ДЛЯ ЧПУ В COTONTI SIENA
// ====================================================================
// При включённом ЧПУ в URL вида /ru/user-guide/projects-manual/tasks-general
// переменные $_GET['c'] и $_GET['id'] пустые! Cotonti парсит URL сам.
// Поэтому мы сами берём текущий URL и выдираем из него код категории.
// === САМОЕ ПРОСТОЕ И САМОЕ НАДЁЖНОЕ РЕШЕНИЕ ===
// В ЧПУ Cotonti первый сегмент после языка — это всегда код категории
// Берём путь из URL и убираем слеши по краям: "/ru/user-guide/..." → "ru/user-guide/..."
/*
// Разбиваем путь на сегменты: 
// "ru/user-guide/projects-manual" → ['ru', 'user-guide', 'projects-manual']
*/

// Берём путь из URL и убираем слеши по краям: "/ru/user-guide/..." → "ru/user-guide/..."
$uri = trim($_SERVER['REQUEST_URI'] ?? '', '/');
$segments = explode('/', $uri);



// Если первый сегмент — это двухбуквенный язык (ru, en, uk и т.д.) — убираем его
// Это нужно, чтобы не перепутать язык с кодом категории
if (isset($segments[0]) && strlen($segments[0]) == 2 && ctype_alpha($segments[0])) {
    array_shift($segments); // теперь $segments[0] — это код категории
}

// Если после языка что-то осталось — значит, это и есть код текущей категории
// Например: user-guide, projects-manual, blog и т.д.
if (!empty($segments[0])) {
    $currentCat = $segments[0]; // вот он — реальный код текущей категории при ЧПУ

    // Проверяем: входит ли текущая категория в поддерево нашей родительской (user-guide)?
    if (pagemycatheader_is_descendant($currentCat, $parentCat)) {
        // Да! Значит мы в нужном разделе — подменяем location
        Cot::$env['location'] = $targetLocation;
        // Выходим сразу — больше ничего проверять не надо
        return;
    }
}

// ===============================================
// ЗАПАСНЫЕ ВАРИАНТЫ (на случай старых ссылок)
// ===============================================

// Если кто-то заходит по старому URL: ?c=projects-manual — тоже сработает
if (!empty($_GET['c'])) {
    $c = cot_import('c', 'G', 'TXT'); // безопасно берём параметр c
    if ($c && pagemycatheader_is_descendant($c, $parentCat)) {
        Cot::$env['location'] = $targetLocation;
        // return не ставим — вдруг дальше есть id=
    }
}

// Если зашли на отдельную страницу по ?id=123 — тоже проверим её категорию
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id']; // приводим к числу
    if ($id > 0) {
        // Делаем запрос в базу: какая категория у этой страницы?
        $cat = Cot::$db->query("SELECT page_cat FROM " . Cot::$db->pages . " WHERE page_id = ? LIMIT 1", [$id])->fetchColumn();
        
        // Если категория найдена и принадлежит нашему дереву — подменяем header
        if ($cat && pagemycatheader_is_descendant((string)$cat, $parentCat)) {
            Cot::$env['location'] = $targetLocation;
        }
    }
}
