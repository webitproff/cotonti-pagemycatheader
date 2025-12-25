<?php
/**
 * pagemycatheader.functions.php
 * Функции плагина Page My Custom Categories and Articles Header Template
 */

// ЗАПРЕТ ЗАПУСКА ВНЕ Cotonti — если кто-то попытается открыть файл напрямую — умрёт
defined('COT_CODE') or die('Wrong URL');

// Подключаем модуль page — без него не будет доступа к:
// - таблице cot_pages
// - функции cot_url()
// - переменной $structure['page']
// - и вообще ко всему, что связано со страницами
require_once cot_incfile('page', 'module');

// Подключаем ядро структуры категорий — это нужно для функции cot_structure_parents()
require_once cot_incfile('structure', 'core');

/**
 * Проверяет, принадлежит ли категория $cat (или её родитель) к дереву $parent
 *
 * Например:
 * $cat = "tasks-general", $parent = "user-guide" → true
 * $cat = "blog", $parent = "user-guide" → false
 *
 * @param string $cat Текущая категория (код)
 * @param string $parent Код родительской категории из настроек плагина
 * @return bool true — если $cat находится в поддереве $parent (или является им)
 */
function pagemycatheader_is_descendant(string $cat, string $parent): bool
{
    // Доступ к глобальным переменным (на всякий случай, хотя они и так есть)
    global $db_pages, $structure;

    // Базовая защита от мусора: пустые значения или системная категория
    if ($cat === '' || $parent === '' || $cat === 'system') {
        return false;
    }

    // Самый простой случай: текущая категория и есть искомый родитель
    if ($cat === $parent) {
        return true;
    }

    // Получаем полный путь родителей от корня до текущей категории
    // Например, для tasks-general → ['user-guide', 'projects-manual', 'tasks-general']
    // В некоторых сборках может вернуть строку типа "user-guide/projects-manual/tasks-general"
    $path = cot_structure_parents('page', $cat, true);

    // Защита, где cot_structure_parents() возвращает строку
    if (is_string($path)) {
        // Если строка пустая — значит категория не существует или корневая
        if ($path === '') return false;
        // Приводим строку к массиву: "a/b/c" → ['a','b','c']
        $path = explode('/', trim($path, '/'));
    }

    // На всякий случай — если по какой-то причине $path не массив (ошибка в структуре)
    if (!is_array($path)) {
        return false;
    }

    // Проверяем, есть ли в цепочке родителей нужная нам родительская категория
    // Например, ищем 'user-guide' в массиве ['user-guide', 'projects-manual', 'tasks-general']
    return in_array($parent, $path, true);
}