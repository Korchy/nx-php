<?php
//---------------------------------
class LanguageNx
{
	private $LanguagesXMLFile;	// Путь к файлу с наборами букв языков

	public function __construct($XMLFile = "") {
		if($XMLFile == "") $this->LanguagesXMLFile = __Dir__."\\language_nx.xml";
		else $this->LanguagesXMLFile = $XMLFile;
	}

	public function __destruct() {
		unset($this->LanguagesXMLFile);
	}
	
	public function DetectLanguage($Text) {
		// Определение языка $Text
		return $this->DetectLanguageByLetters($Text);
	}
	
	private function GetLettersSets() {
		// Получить наботы букв для языков
		$LanguagesXML = new DOMDocument('1.0','utf-8');
		$LanguagesXML->load($this->LanguagesXMLFile);
		$Languages = $LanguagesXML->firstChild->childNodes;
		$LanguagesArray = array();
		foreach($Languages as $Language) {
			$LanguagesArray[$Language->nodeName] = mb_split('\,|\.|\ ',$Language->nodeValue);
		}
		return $LanguagesArray;
	}
	
	private function DetectLanguageByLetters($Text) {
		// Проверяет язык $Text по количеству букв. Возвращает язык.
		$Rez = "";
		$LanguagesArray = $this->GetLettersSets();
		// Подготовка строки: кодировку в UTF8, в нижний регистр
		$Encoding = mb_detect_encoding($Text);
		$Text = mb_convert_encoding($Text, 'UTF-8', $Encoding);
		$Text = mb_strtolower($Text, 'UTF-8');
		// Проверка
		$LastCount = 0;
		foreach($LanguagesArray as $Name => $Letters) {
			$CurrentCount = 0;
			foreach($Letters as $Letter) {
				$CurrentCount += mb_substr_count($Text, $Letter);
			}
			if($CurrentCount > $LastCount) {
				$Rez = $Name;
				$LastCount = $CurrentCount;
			}
		}
		return $Rez;
	}
}
?>
