<?php

/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 11/5/15
 * Time: 10:10 PM
 */
class Location
{

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->pid = $row['pid'];
        $this->sid = $row['sid'];
        $this->name = $row['name'];
        $this->des = $row['description'];
        $this->short = $row['short_description'];
        $this->project_id = $row['project_id'];
        $this->exhibit_id = $row['exhibit_id'];
        $this->thumb_path = $row['thumb_path'];
        $this->headerPath = $row['header_image_path'];
        $this->dig_deeper = $row['dig_deeper'];
        $this->latitude = $row['latitude'];
        $this->longitude = $row['longitude'];
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDes()
    {
        return $this->des;
    }

    /**
     * @return mixed
     */
    public function getShortDes()
    {
        return $this->short;
    }


    /**
     * @return mixed
     */
    public function getDigDeeper()
    {
        return $this->dig_deeper;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getThumbPath()
    {
        return $this->thumb_path;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getExhibitId()
    {
        return $this->exhibit_id;
    }

    /**
     * @return mixed
     */
    public function getHeaderPath()
    {
        return $this->headerPath;
    }

        


    private $id;                ///< The id of this location in the table
    private $project_id;        ///< The project id that this location is in
    private $exhibit_id;        ///< The exhibit id that this location has
    private $pid;               ///< The pid
    private $sid;
    private $name;              ///< The name of this location
    private $des;               ///< The description of this location
    private $dig_deeper;        ///< Dig deeper information
    private $latitude;          ///< The latitude of this location
    private $longitude;         ///< The longitude of this location
    private $thumb_path;        ///< The thumb image path
    private $headerPath;        ///< The header image path
}