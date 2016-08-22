<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/13/15
 * Time: 3:50 PM
 */

class Exhibit {

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->pid = $row['pid'];
        $this->name = $row['name'];
        $this->des = $row['description'];
        $this->project_id = $row['project_id'];
        $this->thumb_path = $row['thumb_path'];
        $this->header_path = $row['header_image_path'];
    }

    /**
     * @return The project id that this exhibit is in
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * @return exhibit id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return exhibit pid
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return exhibit's title
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return exhibit's description
     */
    public function getDes()
    {
        return $this->des;
    }

    /**
     * @return image path
     */
    public function getThumbPath()
    {
        return $this->thumb_path;
    }

    /**
     * @return mixed
     */
    public function getHeaderPath()
    {
        return $this->header_path;
    }



    private $project_id;    ///< The project id that this exhibit is in
    private $id;            ///< The exhibit id in the table
    private $pid;           ///< The exhibit pid
    private $name;          ///< The exhibit name
    private $des;           ///< The exhibit description
    private $thumb_path;    ///< The default image path
    private $header_path;   ///< The header image path
}