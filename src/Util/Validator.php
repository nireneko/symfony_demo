<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 02/01/2019
 * Time: 12:33
 */

namespace App\Util;


use Symfony\Component\Console\Exception\InvalidArgumentException;

class Validator
{

    public function validateUsername(?string $username): string
    {
        if (empty($username)) {
            throw new InvalidArgumentException('The username can not be empty.');
        }
//        if (1 !== preg_match('/^[a-z_]+$/', $username)) {
//            throw new InvalidArgumentException('The username must contain only lowercase latin characters and underscores.');
//        }
        return $username;
    }
    public function validatePassword(?string $plainPassword): string
    {
        if (empty($plainPassword)) {
            throw new InvalidArgumentException('The password can not be empty.');
        }
        return $plainPassword;
    }
    public function validateEmail(?string $email): string
    {
        if (empty($email)) {
            throw new InvalidArgumentException('The email can not be empty.');
        }
        if (false === mb_strpos($email, '@')) {
            throw new InvalidArgumentException('The email should look like a real email.');
        }
        return $email;
    }

}