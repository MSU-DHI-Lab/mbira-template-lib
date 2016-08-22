<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 4/7/16
 * Time: 5:18 PM
 */


class Email
{

    public function mail($to, $subject, $message, $headers)
    {
        mail($to, $subject, $message, $headers);
    }


}