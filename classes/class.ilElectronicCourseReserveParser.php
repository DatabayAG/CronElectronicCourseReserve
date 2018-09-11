<?php
require_once 'Services/Xml/classes/class.ilSaxParser.php';
require_once 'Customizing/global/plugins/Services/Cron/CronHook/CronElectronicCourseReserve/classes/class.ilElectronicCourseReserveContainer.php';
require_once 'Customizing/global/plugins/Services/Cron/CronHook/CronElectronicCourseReserve/classes/class.ilElectronicCourseReserveUrlParser.php';
require_once 'Customizing/global/plugins/Services/Cron/CronHook/CronElectronicCourseReserve/classes/class.ilElectronicCourseReserveFileParser.php';

class ilElectronicCourseReserveParser extends ilSaxParser
{
	/**
	 * @var ilElectronicCourseReserveContainer
	 */
	protected $ele_crs_res;

	/**
	 * @var bool
	 */
	protected $inItemTag;

	/**
	 * @var string
	 */
	public $cdata;

	/**
	 * @param                      $xmlFile
	 */
	public function __construct($xmlFile)
	{
		$this->ele_crs_res = new ilElectronicCourseReserveContainer();
		$this->inItemTag	= false;
		parent::__construct($xmlFile);
	}

	/**
	 * @param $xmlParser
	 * @param $tagName
	 * @param $tagAttributes
	 */
	public function handlerBeginTag($xmlParser, $tagName, $tagAttributes)
	{
		switch($tagName)
		{
			case 'label':
				$folder_import_id = $this->fetchAttribute($tagAttributes, 'id');
				if($folder_import_id > 0)
				{
					$this->ele_crs_res->setFolderImportId($folder_import_id);
				}

				$overwrite = $this->fetchAttribute($tagAttributes, 'overwrite');
				if($overwrite == 1 || strtolower($overwrite) == 'yes' || strtolower($overwrite) == 'true')
				{
					$this->ele_crs_res->setOverwrite(1);
				}
				else {
					$this->ele_crs_res->setOverwrite(0);
				}

				break;

			case 'item':
					$item_type = $this->fetchAttribute($tagAttributes, 'type');
					if(strtolower($item_type) === 'url')
					{
						new ilElectronicCourseReserveUrlParser($this->ele_crs_res, $xmlParser);
						$this->ele_crs_res->setType('url');
					}else if(strtolower($item_type) === 'file')
					{
						new ilElectronicCourseReserveFileParser($this->ele_crs_res, $xmlParser);
						$this->ele_crs_res->setType('file');
					}
					$this->inItemTag = true;
				break;

			case 'timestamp':
				$timestamp = $this->fetchAttribute($tagAttributes, 'value');
				$format = $this->fetchAttribute($tagAttributes, 'format');
				$this->ele_crs_res->setTimestamp($timestamp);
				$this->ele_crs_res->setTimestampFormat($format);
				break;

			case 'semesterapparat':
				$crs_ref_id = $this->fetchAttribute($tagAttributes, 'iliasID');
				$this->ele_crs_res->setCrsRefId($crs_ref_id);
				break;
		}
	}

	/**
	 * @param $xmlParser
	 * @param $tagName
	 */
	public function handlerEndTag($xmlParser, $tagName)
	{
		switch($tagName)
		{
			case 'item':
				$this->inItemTag = false;
				break;

			case 'label':
				$this->ele_crs_res->setLabel(trim($this->cdata));
				$this->cdata = '';
				break;

		}
	}

	/**
	 * @param $attributes
	 * @param $name
	 * @return null
	 */
	private function fetchAttribute($attributes, $name)
	{
		if( isset($attributes[$name]) )
		{
			return $attributes[$name];
		}
		return null;
	}

	/**
	 * @param $xmlParser
	 */
	public function setHandlers($xmlParser)
	{
		xml_set_object($xmlParser, $this);
		xml_set_element_handler($xmlParser, 'handlerBeginTag', 'handlerEndTag');
		xml_set_character_data_handler($xmlParser, 'handlerCharacterData');
	}

	/**
	 * @param $xmlParser
	 * @param $charData
	 */
	public function handlerCharacterData($xmlParser, $charData)
	{
		if($charData != "\n")
		{
			// Replace multiple tabs with one space
			$charData = preg_replace("/\t+/", " ", $charData);

			$this->cdata .= $charData;
		}
	}

	/**
	 * @return ilElectronicCourseReserveContainer
	 */
	public function getElectronicCourseReserveContainer()
	{
		return $this->ele_crs_res;
	}
}