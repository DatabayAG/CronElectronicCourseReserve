<?php
require_once 'Services/Xml/classes/class.ilSaxParser.php';
require_once 'Customizing/global/plugins/Services/Cron/CronHook/CronElectronicCourseReserve/classes/class.ilElectronicCourseReserveFile.php';
class ilElectronicCourseReserveFileParser extends ilSaxParser
{
	/**
	 * @var bool
	 */
	protected $inItemTag;

	/**
	 * @var ilElectronicCourseReserveContainer
	 */
	protected $container;

	/**
	 * ilElectronicCourseReserveUrlParser constructor.
	 * @param ilElectronicCourseReserveContainer $ele_crs_res
	 * @param $xmlFile
	 */
	public function __construct($ele_crs_res, $xmlFile)
	{
		$this->container = $ele_crs_res;
		$this->container->setItem( new ilElectronicCourseReserveFile());
		$this->setHandlers($xmlFile);
		parent::__construct();
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
			case 'icon':
				break;

			case 'file':

				break;

			case 'filename':

				break;

			case 'description':

				break;

			case 'label':

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
			case 'icon':
				$this->container->getItem()->setIcon(trim($this->cdata));
				$this->cdata = '';
				break;

			case 'file':
				$this->container->getItem()->setFile(trim($this->cdata));
				$this->cdata = '';
				break;

			case 'filename':
				$this->container->getItem()->setFilename(trim($this->cdata));
				$this->cdata = '';
				break;

			case 'description':
				$this->container->getItem()->setDescription(trim($this->cdata));
				$this->cdata = '';
				break;

			case 'label':
				$this->container->getItem()->setLabel(trim($this->cdata));
				$this->cdata = '';
				break;
		}
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
		return $this->container;
	}
}