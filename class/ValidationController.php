<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 4/7/16
 * Time: 5:20 PM
 */


class ValidationController {
    /**
     * Constructor
     * @param Site $site The site object
     */
    public function __construct(Site $site) {
        $this->site = $site;
    }

    /**
     * Validate a user
     * @param $validator The validator string
     * @return null or an error message
     */
    public function validate($validator) {
        $users = new Users($this->site);

        $user = $users->confirmUser($validator);
        if($user === null) {
            return "Invalid validator";
        }

        return "Success";
    }

    public function validatePassword($validator) {
        $users = new Users($this->site);
        $np = new NewPassword($this->site);

        $pass = $np->removeNewpassword($validator);
        if($pass === null) {
            return "Invalid validator";
        }

        $users->changePassword($pass);
        return null;
    }

    private $site;
}