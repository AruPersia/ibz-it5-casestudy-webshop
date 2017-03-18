<?php

namespace BackendBundle\Model;

class Orders
{

    private $pendingSize;
    private $processedSize;

    public function __construct($pendingSize, $processedSize)
    {
        $this->pendingSize = $pendingSize;
        $this->processedSize = $processedSize;
    }

    public function getPendingSize()
    {
        return $this->pendingSize;
    }

    public function getProcessedSize()
    {
        return $this->processedSize;
    }

}