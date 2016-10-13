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

        return $user;
    }

    public function validatePassword($validator, $password1, $password2) {
      // Ensure the passwords are valid and equal
      if(strlen($password1) < 8) {
          return "Passwords must be at least 8 characters long";
      }

      if($password1 !== $password2) {
          return "Passwords are not equal";
      }

      $users = new Users($this->site);
      $user = $users->confirmUser($validator);
      if($user === null) {
          return "Invalid validator";
      }


      $users->changePassword($user['email'], $password1);
      return null;
    }

    private $site;
}
