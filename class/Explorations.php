<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/13/15
 * Time: 3:49 PM
 */

class Explorations extends Table{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_explorations");
    }

    /**
     * Get a exploration by id
     * @param $id The exploration by ID
     * @returns Exploration object if successful, null otherwise.
     */
    public function get($id) {
/*        $sql =<<<SQL
SELECT * from $this->tableName
where id=?
SQL;
        */
        $sql = 'SELECT * from '.$this->tableName.' where id=? and project_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id,PROJID));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Exploration($statement->fetch(PDO::FETCH_ASSOC));
    }


    /**
     * @return  the number of explorations in the table
     */
    public function getCount()
    {
/*        $sql =<<<SQL
SELECT * from $this->tableName
SQL;*/

        $sql = 'SELECT * from '.$this->tableName.' where project_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));
        $this->count = $statement->rowCount();

        return $this->count;
    }

    /**
     * @return an array contains the titles of each exploration
     */
    public function getTitles() {
/*        $sql =<<<SQL
SELECT name from $this->tableName
SQL;*/

        $sql = 'SELECT name from '.$this->tableName.' where project_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }


    /**
     * @return an array contains the  image paths of each exploration
     */
    public function getPaths() {
/*        $sql =<<<SQL
SELECT thumb_path from $this->tableName
SQL;*/

        $sql = 'SELECT thumb_path from '.$this->tableName.' where project_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /*
    * Gets the comments toggle setting
    * @param $id The location ID
    * @returns true/false
    */
    public function getCommentsToggle($id) {
        $sql = 'SELECT toggle_comments from mbira_explorations where id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll();
    }


    /**
     * @return an array contains the id of each exploration
     */
    public function getIDs() {
/*        $sql =<<<SQL
SELECT id from $this->tableName
SQL;*/

        $sql ='SELECT id from '.$this->tableName.' where project_id=?';

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(PROJID));

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private $count = 0;             ///< the number of explorations in the table

}
