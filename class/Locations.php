<?php

/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 11/5/15
 * Time: 10:08 PM
 */
class Locations extends \Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_locations");
    }

    /**
     * Get a location by id
     * @param $id The location by ID
     * @returns Location object if successful, null otherwise.
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

        return new Location($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get a random location id
     * @returns Random location id if successful, null otherwise.
     */
    public function get_random() {
        $sql =<<<SQL
SELECT id from $this->tableName
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }

        $locations = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $locations[array_rand($locations,1)] ;
    }

    /**
     * Get an arrya of media by location id
     * @param $id The location ID
     * @returns Array of file paths if successful, null otherwise.
     */
    public function getMedia($id) {
        $sql =<<<SQL
SELECT * from mbira_loc_media
where location_id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll();
    }
}