<?php

namespace Linqur\IikoService\Entity\Organization;

class Builder
{
    public static function byRepository($row)
    {
        return self::build($row->id, $row->name, (new \DateTime())->setTimestamp($row->created));
    }

    public static function byResponse($body)
    {
        return self::build($body['id'], $body['name'], new \DateTime('now'));
    }

    private static function build($id, $name, $created)
    {
        $organization = new Organization();

        $organization->id = $id;
        $organization->name = $name;
        $organization->createdTime = $created;

        return $organization;
    }
}