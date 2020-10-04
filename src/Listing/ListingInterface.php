<?php


namespace Igornast\DataTables\Listing;


interface ListingInterface
{
    public function getColumns(): array;

    public function getTemplate(): string ;

    public function getEncryptedEntity(): ?string;
}