<?php

namespace Tests;

trait ForeignKeys
{
    /**
     * Enables foreign keys.
     *
     * @return void
     */
    public function enableForeignKeys()
    {
        $db = app()->make('db');
        $db->getSchemaBuilder()->enableForeignKeyConstraints();
    }
}