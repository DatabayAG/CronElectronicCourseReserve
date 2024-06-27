<?php

class ilElectronicCourseReserveContainer
{
    /**
     * @var string
     */
    protected string $label = '';

    /**
     * @var string
     */
    protected string $timestamp = '';

    /**
     * @var string
     */
    protected string $timestamp_format = '';


    protected ilElectronicCourseReserveUrl|ilElectronicCourseReserveFile|null $item = null;

    /**
     * @var string
     */
    protected string $type = '';

    /**
     * @var int
     */
    protected int $crs_ref_id = 0;

    /**
     * @var int
     */
    protected int $folder_import_id = 0;

    /**
     * @var int
     */
    protected int $overwrite = 0;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getTimestampFormat(): string
    {
        return $this->timestamp_format;
    }

    /**
     * @param string $timestamp_format
     */
    public function setTimestampFormat(string $timestamp_format): void
    {
        $this->timestamp_format = $timestamp_format;
    }

    public function getItem(): ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl|null
    {
        return $this->item;
    }

    /**
     * @param ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl $item
     */
    public function setItem(ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl $item): void
    {
        $this->item = $item;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getCrsRefId(): int
    {
        return $this->crs_ref_id;
    }

    /**
     * @param int $crs_ref_id
     */
    public function setCrsRefId(int $crs_ref_id): void
    {
        $this->crs_ref_id = $crs_ref_id;
    }

    /**
     * @return int
     */
    public function getFolderImportId(): int
    {
        return $this->folder_import_id;
    }

    /**
     * @param int $folder_import_id
     */
    public function setFolderImportId(int $folder_import_id): void
    {
        $this->folder_import_id = $folder_import_id;
    }

    /**
     * @return int
     */
    public function getOverwrite(): int
    {
        return $this->overwrite;
    }

    /**
     * @param int $overwrite
     */
    public function setOverwrite(int $overwrite): void
    {
        $this->overwrite = $overwrite;
    }


}