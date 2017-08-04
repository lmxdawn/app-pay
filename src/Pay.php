<?php
/**
 * Created by PhpStorm.
 * User: Elvis Lee
 * Date: 2016/12/19
 * Time: 13:35
 */

namespace lmxdawn\appPay;


abstract class Pay
{

    protected static $instance;

    abstract protected function request($data);
    abstract protected function serializeParams($data);
}