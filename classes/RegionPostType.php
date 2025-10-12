<?php

declare(strict_types=1);

namespace Castlegate\AlcoholicsAnonymous;

class RegionPostType extends AbstractRegionPostType
{
    /**
     * Post type name
     *
     * @var string
     */
    public const NAME = 'region';

    /**
     * Post type slug
     *
     * @var string|null
     */
    public const SLUG = 'regions';

    /**
     * Label (single)
     *
     * @var string|null
     */
    public const LABEL_SINGLE = 'Region Page';

    /**
     * Label (plural)
     *
     * @var string|null
     */
    public const LABEL_PLURAL = 'Region Pages';

    /**
     * Overrides for specific labels
     *
     * @var array|null
     */
    public const LABEL_OVERRIDES = [
        'menu_name' => 'Regions',
    ];

    /**
     * Capability type
     *
     * @var array|null
     */
    public const CAPABILITY_TYPE = ['region', 'regions'];
}
