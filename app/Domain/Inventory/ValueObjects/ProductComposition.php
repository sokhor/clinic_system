<?php
namespace App\Domain\Inventory\ValueObjects;

class ProductComposition
{
    public $composeOf;

    public function __construct(array $composeOf)
    {
        $this->composeOf = $composeOf;
    }

    public function serialize(): string
    {
        return json_encode($this->composeOf);
    }
}
