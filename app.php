<?php
use \FileRun\WebLinks;

class custom_virustotal extends \FileRun\Files\Plugin {

	static $localeSection = 'Custom Actions: Scan for Virus';

	function init() {
		$this->settings = [
			[
				'key' => 'APIKey',
				'title' => self::t('VirusTotal API Key'),
				'comment' => '<a href="https://support.virustotal.com/hc/en-us/articles/115002088769-Please-give-me-an-API-key" target="_blank">Getting a Virus Total API Key</a>'
			]
		];
		$this->JSconfig = [
			'title' => self::t("Scan for Virus"),
			'icon' => 'customizables/plugins/virustotal/icon.png',
			'popup' => true,
			'width' => 800, 'height' => 450,
			'requires' => ['preview']
		];
	}

	function isDisabled() {
		return (strlen(self::getSetting('APIKey')) == 0);
	}

	function run() {
		$size = \FM::getFileSize($this->data['fullPath']);

		if($size <= 31457280)
		{
			$fileName = $this->data['fullPath'];
			$vt_key = self::getSetting('APIKey');
			$hash = hash_file('sha256', $fileName);
			$vt_json = file_get_contents("https://www.virustotal.com/vtapi/v2/file/report?apikey=$vt_key&resource=$hash");
			$vt_json_result = json_decode($vt_json, true);
			if($vt_json_result['response_code'] == 0) {
				require_once('virustotal.class.php');
				$vt = new virustotal(self::getSetting('APIKey'));
				$vt->checkFile($this->data['fullPath']);
			}
			$this->logAction();
			require $this->path."/display.php";
		}
		else {
			require $this->path."/display_error.php";
			$this->logAction();
		}
	}
}
