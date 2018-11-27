<?php

namespace App\Service\Manager;

use \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class FlashBagManager
 * @package App\Service\Manager
 */
class FlashBagManager
{
    /**
     * @var string const TYPE_SUCCESS
     */
    public const TYPE_SUCCESS = 'success';

    /**
     * @var string const TYPE_ERROR
     */
    public const TYPE_ERROR = 'error';

    /**
     * @var string const TYPE_WARNING
     */
    public const TYPE_WARNING = 'warning';

    /**
     * @var string const TYPE_INFO
     */
    public const TYPE_INFO = 'info';

    /**
     * @var FlashBagInterface $flashBag
     */
    private $flashBag;

    /**
     * FlashBagManager constructor.
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * @param string $type
     * @param string $message
     */
    public function add(string $type, string $message): void
    {
        $this->flashBag->add($type, $message);
    }
}