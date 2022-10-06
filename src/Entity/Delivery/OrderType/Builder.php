<?php

namespace Linqur\IikoService\Entity\Delivery\OrderType;

class Builder
{
    /** @return OrderType */
    public static function byRepository($row)
    {
        return self::build($row->id, $row->organization_id, $row->name, $row->order_service_type, (new \DateTime())->setTimestamp($row->created));
    }

    /** @return OrderType */
    public static function byResponse($row)
    {
        return self::build($row['id'], $row['organizationId'], $row['name'], $row['orderServiceType'], new \DateTime('now'));
    }
    
    /** @return OrderType */
    private static function build($id, $organizationId, $name, $orderServiceType, $created)
    {
        $orderType = new OrderType();

        $orderType->id = $id;
        $orderType->organizationId = $organizationId;
        $orderType->name = $name;
        $orderType->orderServiceType = $orderServiceType;
        $orderType->created = $created;

        return $orderType;
    }
}
