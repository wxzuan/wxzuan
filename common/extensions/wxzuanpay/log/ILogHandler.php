<?php
namespace extensions\wxzuanpay\log;
interface ILogHandler {

    public function write($msg);
}