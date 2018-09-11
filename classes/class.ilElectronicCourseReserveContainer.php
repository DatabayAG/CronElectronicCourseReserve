<?php

class ilElectronicCourseReserveContainer
{
	/**
	 * @var string 
	 */
	protected $label = '';

	/**
	 * @var string 
	 */
	protected $timestamp = '';

	/**
	 * @var string 
	 */
	protected $timestamp_format = '';

	/**
	 * @var ilElectronicCourseReserveFile | ilElectronicCourseReserveUrl
	 */
	protected $item = null;

	/**
	 * @var string 
	 */
	protected $type = '';

	/**
	 * @var int 
	 */
	protected $crs_ref_id = 0;

	/**
	 * @var int 
	 */
	protected $folder_import_id = 0;

	/**
	 * @var int 
	 */
	protected $overwrite = 0;

	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}

	/**
	 * @return string
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * @param string $timestamp
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	/**
	 * @return string
	 */
	public function getTimestampFormat()
	{
		return $this->timestamp_format;
	}

	/**
	 * @param string $timestamp_format
	 */
	public function setTimestampFormat($timestamp_format)
	{
		$this->timestamp_format = $timestamp_format;
	}

	/**
	 * @return ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl
	 */
	public function getItem()
	{
		return $this->item;
	}

	/**
	 * @param ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl $item
	 */
	public function setItem($item)
	{
		$this->item = $item;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return int
	 */
	public function getCrsRefId()
	{
		return $this->crs_ref_id;
	}

	/**
	 * @param int $crs_ref_id
	 */
	public function setCrsRefId($crs_ref_id)
	{
		$this->crs_ref_id = $crs_ref_id;
	}

	/**
	 * @return int
	 */
	public function getFolderImportId()
	{
		return $this->folder_import_id;
	}

	/**
	 * @param int $folder_import_id
	 */
	public function setFolderImportId($folder_import_id)
	{
		$this->folder_import_id = $folder_import_id;
	}

	/**
	 * @return int
	 */
	public function getOverwrite()
	{
		return $this->overwrite;
	}

	/**
	 * @param int $overwrite
	 */
	public function setOverwrite($overwrite)
	{
		$this->overwrite = $overwrite;
	}


}