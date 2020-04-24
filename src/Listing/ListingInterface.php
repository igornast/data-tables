<?php


namespace Igornast\DataTables\Listing;


interface ListingInterface
{
    public function getColumns(): array;

    public function getEncryptedEntity(): ?string;

    public function getPathName(): ?string;
}