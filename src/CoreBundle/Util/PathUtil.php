<?php

namespace CoreBundle\Util;

class PathUtil
{
    private $rootDir;
    private $appDir;
    private $webDir;

    public function __construct($appDir)
    {
        $this->rootDir = realpath($appDir . '/../');
        $this->appDir = realpath($this->rootDir . '/app/');
        $this->webDir = realpath($this->rootDir . '/web/');
    }

    public function getAppDir($extend)
    {
        return $this->extend($this->git , $extend);
    }

    public function getWebDir($extend)
    {
        return $this->extend($this->webDir, $extend);
    }

    function __toString()
    {
        return sprintf('rootDir:%s; appDir:%s, webDir:%s', $this->rootDir, $this->appDir, $this->webDir);
    }

    private function extend($base, $extend)
    {
        return $base . '/' . ltrim($extend, '/');
    }

}