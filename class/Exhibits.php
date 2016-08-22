<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/13/15
 * Time: 3:49 PM
 */

class Exhibits extends Table{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_exhibits");
    }

    /**
     * Get a exhibit by id
     * @param $id The exhibit by ID
     * @returns Exhibit object if successful, null otherwise.
     */
    public function get($id) {    
        $sql = 'SELECT * from '.$this->tableName.'
            where id=? and project_id=?';
        
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id,PROJID));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Exhibit($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get an array of location ids
     * @param $id The exhibit id
     * @return  the array of location ids associated with the give exhibit id
     */
    public function getLocationID($id) {
        $sql = 'SELECT * from mbira_locations_has_mbira_exhibits
                where mbira_exhibits_id=?';


        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Get an array of location ids
     * @param $id The exhibit id
     * @return  the array of location ids associated with the give exhibit id
     */
    public function getAreaID($id) {
        $sql = 'SELECT * from mbira_areas_has_mbira_exhibits
                where mbira_exhibits_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }


    /**
     * @return  the number of exhibits in the table
     */
    public function getCount()
    {
        $sql = 'SELECT * from '.$this->tableName.' where project_id=?';
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));
        $this->count = $statement->rowCount();

        return $this->count;
    }

    /**
     * @return an array contains the titles of each exhibit
     */
    public function getTitles() {
        $sql = 'SELECT name from '.$this->tableName.' where project_id=?';
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }


    /**
     * @return an array contains the image paths of each exhibit
     */
    public function getPaths() {
        $sql ='SELECT thumb_path from '.$this->tableName.' where project_id=?';
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }


    /**
     * @return an array contains the id of each exhibit
     */
    public function getIDs() {
        $sql = 'SELECT id from '.$this->tableName.' where project_id=?';
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private $count = 0;             ///< the number of exhibits in the table

}