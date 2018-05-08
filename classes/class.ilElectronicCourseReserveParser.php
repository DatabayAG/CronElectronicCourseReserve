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
				break;

			case 'item':
					$item_type = $this->fetchAttribute($tagAttributes, 'type');
					if(strtolower($item_type) === 'url')
					{
						new ilElectronicCourseReserveUrlParser($this->ele_crs_res, $xmlParser);
					}else if(strtolower($item_type) === 'file')
					{
						new ilElectronicCourseReserveFileParser($this->ele_crs_res, $xmlParser);
					}
					$this->inItemTag = true;
				break;

			case 'timestamp':
				$timestamp = $this->fetchAttribute($tagAttributes, 'value');
				$format = $this->fetchAttribute($tagAttributes, 'format');
				$this->ele_crs_res->setTimestamp($timestamp);
				$this->ele_crs_res->setTimestampFormat($format);
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