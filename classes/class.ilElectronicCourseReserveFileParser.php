<?php

require_once 'Services/Xml/classes/class.ilSaxParser.php';
require_once 'Customizing/global/plugins/Services/Cron/CronHook/CronElectronicCourseReserve/classes/class.ilElectronicCourseReserveFile.php';

class ilElectronicCourseReserveFileParser extends ilSaxParser
{
    /**
     * @var bool
     */
    protected bool $inItemTag;

    /**
     * @var ilElectronicCourseReserveContainer
     */
    protected ilElectronicCourseReserveContainer $container;

    /**
     * @var string
     */
    public string $cdata = '';

    /**
     * ilElectronicCourseReserveUrlParser constructor.
     * @param ilElectronicCourseReserveContainer $ele_crs_res
     * @param $xmlFile
     */
    public function __construct($ele_crs_res, $xmlFile)
    {
        $this->container = $ele_crs_res;
        $this->container->setItem(new ilElectronicCourseReserveFile());
        $this->setHandlers($xmlFile);
        parent::__construct();
    }

    /**
     * @param $xmlParser
     * @param $tagName
     * @param $tagAttributes
     */
    public function handlerBeginTag($xmlParser, $tagName, $tagAttributes): void
    {
    }

    /**
     * @param $xmlParser
     * @param $tagName
     */
    public function handlerEndTag($xmlParser, $tagName): void
    {
        switch ($tagName) {
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

            case 'metadata':
                $this->container->getItem()->setMetadata(trim($this->cdata));
                $this->cdata = '';
                break;
        }
    }

    /**
     * @param $a_xml_parser
     */
    public function setHandlers($a_xml_parser): void
    {
        xml_set_object($a_xml_parser, $this);
        xml_set_element_handler($a_xml_parser, 'handlerBeginTag', 'handlerEndTag');
        xml_set_character_data_handler($a_xml_parser, 'handlerCharacterData');
    }

    /**
     * @param $xmlParser
     * @param $charData
     */
    public function handlerCharacterData($xmlParser, $charData): void
    {
        if ($charData != "\n") {
            // Replace multiple tabs with one space
            $charData = preg_replace("/\t+/", " ", $charData);

            $this->cdata .= $charData;
        }
    }

    /**
     * @return ilElectronicCourseReserveContainer
     */
    public function getElectronicCourseReserveContainer(): ilElectronicCourseReserveContainer
    {
        return $this->container;
    }
}
