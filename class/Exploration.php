<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/13/15
 * Time: 3:50 PM
 */

class Exploration {

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
        $this->headerPath = $row['header_image_path'];
        $this->stops = $row['direction'];
    }

    /**
     * @return The project id that this exploration is in
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * @return exploration id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return exploration pid
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return exploration's title
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return exploration's description
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
    public function getStops()
    {
        return explode(',', $this->stops);
    }

    /**
     * @return mixed
     */
    public function getHeaderPath()
    {
        return $this->headerPath;
    }
    
    /**
    * @return mixed
    */
    public function getComments()
    {
        $sql = 'SELECT * from '.$this->tableName.' where exploration_id=?';
        
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($this->id));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
    
    

    private $project_id;    ///< The project id that this exploration is in
    private $id;            ///< The exploration id in the table
    private $pid;           ///< The exploration pid
    private $name;          ///< The exploration name
    private $des;           ///< The exploration description
    private $thumb_path;    ///< The thumb image path
    private $headerPath;    ///< The header image path
    private $stops;         ///< The location ids
}