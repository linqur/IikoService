<?php

namespace Linqur\IikoService\Entity\Terminal;

class Builder
{
    /** @return Terminal */
    public static function byRepository($row)
    {
        return self::build($row->id, $row->organization_id, $row->name, $row->address, (new \DateTime())->setTimestamp($row->created));
    }

    /** @return Terminal */
    public static function byResponse($row)
    {
        return self::build($row['id'], $row['organizationId'], $row['name'], $row['address'], new \DateTime('now'));
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