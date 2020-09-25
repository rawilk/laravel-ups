<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Tracking;

class TrackingOptions
{
    /** @var string */
    public const LAST_ACTIVITY = '0';

    /** @var string */
    public const ALL_ACTIVITY = '1';

    /**
     * POD, Receiver Address and Last Activity
     *
     * @var string
     */
    public const POD_LAST_ACTIVITY = '2';

    /**
     * POD, Receiver Address, All Activity
     *
     * @var string
     */
    public const POD_ALL_ACTIVITY = '3';

    /**
     * POD, COD, Last Activity
     *
     * @var string
     */
    public const POD_COD_LAST_ACTIVITY = '4';

    /**
     * POD, COD, All Activity
     *
     * @var string
     */
    public const POD_COD_ALL_ACTIVITY = '5';

    /**
     * POD, COD, Receiver Address, Last Activity
     *
     * @var string
     */
    public const POD_COD_RECEIVER_LAST_ACTIVITY = '6';

    /**
     * POD, COD, Receiver Address, All Activity
     *
     * @var string
     */
    public const POD_COD_RECEIVER_ALL_ACTIVITY = '7';
}
