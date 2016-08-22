<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/8/15
 * Time: 3:56 PM
 */

class Projects extends Table{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_projects");
    }

    /**
     * Get a project by id
     * @param $id The project by ID
     * @returns Project object if successful, null otherwise.
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

        return new Project($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get a project by id
     * @param $id The project by ID
     * @returns Project object if successful, null otherwise.
     */
    public function get_all() {
        $sql =<<<SQL
SELECT id from $this->tableName
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}