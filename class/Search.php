<?php

/**
 * Searches our system.
 */
class Search extends Table {

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_");
    }


    /**
     * Create a new search.
     * @param $query New Query
     * @returns JSON Object of search, error message included or null if no error
     */
    public function newSearch($query) {

        if(strlen($query) == 0) {
            return ["errors" => "Query cannot be empty"];
        }

        $q_string = $query;
        // $pieces = explode(" ", $query);
        //
        // $q_string = "";
        // foreach ($pieces as &$word) {
        //     if (strlen($word) >= 4) {
        //       $q_string .= '+' . $word . " ";
        //     }
        // }
        //
        // unset($word);

        $q_string = "%" . trim($q_string) . "%";

        $response = [];

// SELECT * FROM mbira_locations WHERE MATCH(name, description, short_description, dig_deeper) AGAINST(?) Order By id DESC LIMIT 10

        $sql =<<<SQL
SELECT * FROM mbira_locations WHERE (`name` LIKE :query) OR (`description` LIKE :query)
OR (`short_description` LIKE :query) OR (`dig_deeper` LIKE :query) Order By id DESC LIMIT 10
SQL;

        $pdo = $this->pdo();
        // $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':query', $q_string, PDO::PARAM_STR);
        $statement->execute();
        $response["locations"] = $statement->fetchAll();

// SELECT * FROM mbira_areas WHERE MATCH(name, description, short_description, dig_deeper) AGAINST(?) Order By id DESC LIMIT 10

$sql =<<<SQL
SELECT * FROM mbira_areas WHERE (`name` LIKE :query) OR (`description` LIKE :query)
OR (`short_description` LIKE :query) OR (`dig_deeper` LIKE :query) Order By id DESC LIMIT 10
SQL;

        $pdo = $this->pdo();
        // $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':query', $q_string, PDO::PARAM_STR);
        $statement->execute();
        $response["areas"] = $statement->fetchAll();


// SELECT * FROM mbira_exhibits WHERE MATCH(name, description, short_description, dig_deeper) AGAINST(?) Order By id DESC LIMIT 10

$sql =<<<SQL
SELECT * FROM mbira_exhibits WHERE (`name` LIKE :query) OR (`description` LIKE :query)
OR (`short_description` LIKE :query) OR (`dig_deeper` LIKE :query) Order By id DESC LIMIT 10
SQL;

        $pdo = $this->pdo();
        // $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':query', $q_string, PDO::PARAM_STR);
        $statement->execute();
        $response["exhibits"] = $statement->fetchAll();


// SELECT * FROM mbira_explorations WHERE MATCH(name, description, short_description, dig_deeper) AGAINST(?) Order By id DESC LIMIT 10

$sql =<<<SQL
SELECT * FROM mbira_explorations WHERE (`name` LIKE :query) OR (`description` LIKE :query)
OR (`short_description` LIKE :query) OR (`dig_deeper` LIKE :query) Order By id DESC LIMIT 10
SQL;

        $pdo = $this->pdo();
        // $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':query', $q_string, PDO::PARAM_STR);
        $statement->execute();
        $response["explorations"] = $statement->fetchAll();


        return $response;
    }

}
