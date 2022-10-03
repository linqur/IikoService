<?php

namespace Linqur\IikoService\Entity\Customer;

class Customer
{
    /** @var string */
    public $id;
    /** @var string */
    public $refererId;
    /** @var string */
    public $name;
    /** @var string */
    public $surname;
    /** @var string */
    public $middleName;
    /** @var string */
    public $comment;
    /** @var string */
    public $phone;
    /** @var string */
    public $cultureName;
    /** @var \DateTimeInterface */
    public $birthday;
    /** @var string */
    public $email;
    /** @var int */
    public $sex;
    /** @var int */
    public $consentStatus;
    /** @var bool */
    public $anonymized;
    /** @var Card[] */
    public $cards;
    /** @var Category[] */
    public $categories;
    /** @var WaletBalance[] */
    public $walletBalances;
    /** @var string */
    public $userData;
    /** @var bool */
    public $shouldReceivePromoActionsInfo;
    /** @var bool */
    public $shouldReceiveLoyaltyInfo;
    /** @var bool */
    public $shouldReceiveOrderStatusInfo;
    /** @var \DateTimeInterface */
    public $personalDataConsentFrom;
    /** @var \DateTimeInterface */
    public $personalDataConsentTo;
    /** @var \DateTimeInterface */
    public $personalDataProcessingFrom;
    /** @var \DateTimeInterface */
    public $personalDataProcessingTo;
    /** @var bool */
    public $isDeleted;
}
