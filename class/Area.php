<?php

/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 11/5/15
 * Time: 10:10 PM
 */
class Area
{
    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->des = $row['description'];
        $this->short = $row['short_description'];
        $this->project_id = $row['project_id'];
        $this->dig_deeper = $row['dig_deeper'];
        $this->coordinates = $row['coordinates'];
        $this->shape = $row['shape'];
        $this->thumb_path = $row['thumb_path'];
        $this->headerPath = $row['header_image_path'];
    }
    
    public function getCenter() {

        $coordinates = str_replace(str_split('\\[]'), '', $this->coordinates);
        $coordinatesArray = explode(',', $coordinates);

        $lati = 0;
        $long = 0;

        $count = count($coordinatesArray);
        for($x = 0; $x < $count; $x++) {
            if( $x % 2 ) {
                $long += $coordinatesArray[$x];
            } else {
                $lati += $coordinatesArray[$x];
            }
        }
        return array($lati/$count*2, $long/$count*2);
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
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return mixed
     */
    public function getShape()
    {
        return $this->shape;
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
    public function getDigDeeper()
    {
        return $this->dig_deeper;
    }

    /**
     * @return mixed
     */
    public function getHeaderPath()
    {
        return $this->headerPath;
    }

    

    private $id;                ///< The id of this area in the table
    private $project_id;        ///< The project id that this area is in
    private $name;              ///< The name of this area
    private $des;               ///< The description of this area
    private $coordinates;       ///< The coordinates of this area
    private $dig_deeper;        ///< Dig deeper information
    private $geoJSON_path;
    private $shape;
    private $thumb_path;        ///< The thumb image path
    private $headerPath;        ///< The header image path

}