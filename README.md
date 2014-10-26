php-nx: language
================

Language extensions

Usage
================
require_once("language.inc.php");
$Lang = new LanguageNx();
echo $Lang->DetectLanguage("Текст на русском");   // rus
echo $Lang->DetectLanguage("English text");       // eng
