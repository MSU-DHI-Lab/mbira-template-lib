<?php

/**
 * Manage users in our system.
 */
class Users extends Table {

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "mbira_users");
    }


    /**
     * Create a new user.
     * @param $userid New user ID
     * @param $name New user name
     * @param $email User email address
     * @param $password1 The new password
     * @param $password2 The new password second copy
     * @param Email $mailer An Email object we will use to send email
     * @returns Error message or null if no error
     */
    public function newUser($username, $firstname, $lastname, $email, $password1, $password2, Email $mailer) {

        if(strlen($username) == 0) {
            return "Username cannot be empty";
        }

        // Ensure we have no duplicate username or email address
        $users = new Users($this->site);
        if($users->exists($email)) {
            return "Email address already exists.";
        }

        // Ensure the passwords are valid and equal
        if(strlen($password1) < 8) {
            return "Passwords must be at least 8 characters long";
        }

        if($password1 !== $password2) {
            return "Passwords are not equal";
        }
        
        // Create a validator key
        $validator = $this->createValidator();

        // Create salt and encrypted password
        $salt = self::random_salt();
        $pass = hash("sha256", $password1 . $salt);

        // Add a record to the newuser table
        $sql = <<<SQL
INSERT INTO $this->tableName (username, email, password, salt, firstName, lastName, validator)
values(?, ?, ?, ?, ?, ?, ?)
SQL;

        $this->pdo()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        try {
            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($username, $email, $pass, $salt, $firstname, $lastname, $validator));
        } catch (PDOException $e){
            echo $e->getMessage();
        }

        $lastId = $this->pdo()->lastInsertId();

        $sql = <<<SQL
INSERT INTO mbira_projects_has_mbira_users (mbira_users_id, mbira_projects_id)
values(?, ?)
SQL;


        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($lastId, $this->site->getProjectId()));

        // Send email with the validator in it
        $link = $this->site->getRoot() . '/signup-validate.php?v=' . $validator;

        $from = $this->site->getEmail();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $firstname,</p>

<p>Welcome to Mbira. In order to complete your registration,
please verify your email address by clicking the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($email, $subject, $message, $headers);
    }

    /**
     * @brief Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     */
    private function createValidator($len = 32) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * @brief Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     */
    public static function random_salt($len = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * Determine if a user exists in the system.
     * @param $user string username or a email address.
     * @returns true if $user is an existing user ID or email address
     */
    public function exists($user) {
        $sql =<<<SQL
SELECT * from $this->tableName
where username=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user, $user));
        if($statement->rowCount() === 0) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Test for a valid login.
     * @param $user User id or email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($user, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where username=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user, $user));
        if($statement->rowCount() === 0) {
            return 'Username or Email doesn\'t exist.';
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // if($row['confirmed'] == 0) {
        //     return 'Validate your email before trying to log in.';
        // }
        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return 'Password incorrect';
        }
        return new User($row);
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
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

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function getUser($user) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userid=? or email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user,$user));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Add a user to the site
     * @param $user An array of user information containing keys for:
     * userid, name, email, password, salt, and joined.
     */
    public function add($user) {
        $sql =<<<SQL
INSERT INTO $this->tableName (id,username,email,password,salt,firstName,lastName,confirmed,validator)
VALUES (?,?,?,?,?,?,?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user['id'],
                            $user['username'],
                            $user['email'],
                            $user['password'],
                            $user['salt'],
                            $user['firstName'],
                            $user['lastName'],
                            $user['confirmed'],
                            $user['validator']));
    }

    /**
     * Get a new user record, removing it when we are done.
     * @param $validator The validator string
     * @returns Array with key for each column or null if the validator does not exist.
     */
    public function confirmUser($validator) {
        $sql =<<<SQL
SELECT * from $this->tableName
where validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));
        if($statement->rowCount() === 0) {
            return null;
        }
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $sql =<<<SQL
UPDATE $this->tableName SET confirmed = 1 
where validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));

        return $user;
    }
    
    /**
     * @param $user a user id or email
     * @param $pass the new password
     */
    public function changePassword($pass) {
        $sql =<<<SQL
UPDATE $this->tableName
SET password = ?, salt = ?
where username=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($pass['password'],$pass['salt'],$pass['id'],$pass['id']));
    }
}