<?php

/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 11/5/15
 * Time: 10:08 PM
 */
class Areas extends \Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_areas");
    }

    /**
     * Get a random area id
     * @returns Random area id if successful, null otherwise.
     */
    public function get_random() {
        $sql ='SELECT id from '.$this->tableName.' where project_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));
        if($statement->rowCount() === 0) {
            return null;
        }

        $areas = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $areas[array_rand($areas,1)] ;
    }


    /**
     * Get a area by id
     * @param $id The area by ID
     * @returns Area object if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Area($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get all areas
     * @returns Area objects if successful, null otherwise.
     */
    public function getAll() {
        $sql =<<<SQL
SELECT * from $this->tableName
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }

        // $loc_array = [];
        // while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        //     array_push($loc_array, new Location($row));
        // }

        return $statement->fetchAll();
    }  


    /**
     * Get an arrya of media by location id
     * @param $id The location ID
     * @returns Array of file paths if successful, null otherwise.
     */
    public function getMedia($id) {
        $sql =<<<SQL
SELECT * from mbira_area_media
where area_id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll();

    }

    /**
     * Get exhibit id associated with given area
     * @param $id The area id
     * @return  the id of exhibit that associated with the give area id
     */
    public function getExhibitID($id) {
        $sql =<<<SQL
SELECT mbira_exhibits_id from mbira_areas_has_mbira_exhibits
where mbira_areas_id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
    
    
    /*
    * Gets the dig deeper toggle setting
    * @param $id The area ID
    * @returns true/false
    */
    public function getDigDeeperToggle($id) {
        $sql = 'SELECT toggle_dig_deeper from mbira_areas where id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll();
    }
    
    
    /*
    * Gets the media toggle setting
    * @param $id The area ID
    * @returns true/false
    */
    public function getMediaToggle($id) {
        $sql = 'SELECT toggle_media from mbira_areas where id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll();
    }
    
    /*
    * Gets the comments toggle setting
    * @param $id The area ID
    * @returns true/false
    */
    public function getCommentsToggle($id) {
        $sql = 'SELECT toggle_comments from mbira_areas where id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll();
    }
    
    
    
    
    
}