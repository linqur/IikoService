<?php

namespace Linqur\IikoService\Entity\Terminal;

class Builder
{
    /** @return Terminal */
    public static function byRepository($row)
    {

    }

    /** @return Terminal */
    public static function byResponse($row)
    {

    }
    
    /** @return Terminal */
    private static function build($id, $organizationId, $name, $address, $created)
    {
        $terminal = new Terminal();

        $terminal->id = $id;
        $terminal->organizationId = $organizationId;
        $terminal->name = $name;
        $terminal->address = $address;
        $terminal->created = $created;

        return $terminal;
    }
}