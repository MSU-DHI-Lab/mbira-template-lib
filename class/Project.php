<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/8/15
 * Time: 3:30 PM
 */

class Project {

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->pid = $row['pid'];
        $this->name = $row['name'];
        $this->des = $row['description'];
        $this->shortdes = $row['shortDescription'];
        $this->imagePath = $row['image_path'];
        $this->headerPath = $row['header_image_path'];
        $this->logoPath = $row['logo_image_path'];
    }


    /**
     * @return project id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return project pid
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return project name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return project description
     */
    public function getDes()
    {
        return $this->des;
    }

    /**
     * @return project short description
     */
    public function getShortdes()
    {
        return $this->shortdes;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @return mixed
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * @return mixed
     */
    public function getHeaderPath()
    {
        return $this->headerPath;
    }

    

    private $id;            ///< The project id in the table
    private $pid;           ///< The project pid
    private $name;          ///< The project name
    private $des;           ///< The project description
    private $shortdes;      ///< The project short description
    private $imagePath;     ///< The path of the project image
    private $headerPath;    ///< The path of the header image
    private $logoPath;      ///< The path of the project logo image
}