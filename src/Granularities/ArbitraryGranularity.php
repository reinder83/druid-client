<?php
declare(strict_types=1);

namespace Level23\Druid\Granularities;

use InvalidArgumentException;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Collections\IntervalCollection;

class ArbitraryGranularity implements GranularityInterface
{
    /**
     * @var \Level23\Druid\Types\Granularity|string
     */
    protected $queryGranularity;

    /**
     * @var bool
     */
    protected $rollup;

    /**
     * @var IntervalCollection
     */
    protected $intervals;

    /**
     * UniformGranularity constructor.
     *
     * @param string|Granularity $queryGranularity
     * @param bool               $rollup
     * @param IntervalCollection $intervals
     */
    public function __construct($queryGranularity, bool $rollup, IntervalCollection $intervals)
    {
        if (is_string($queryGranularity) && !Granularity::isValid($queryGranularity)) {
            throw new InvalidArgumentException(
                'The given query granularity is invalid: ' . $queryGranularity . '. ' .
                'Allowed are: ' . implode(',', Granularity::values())
            );
        }

        $this->queryGranularity = $queryGranularity;
        $this->rollup           = $rollup;
        $this->intervals        = $intervals;
    }

    /**
     * Return the granularity in array format so that we can use it in a druid request.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'             => 'arbitrary',
            'queryGranularity' => $this->queryGranularity,
            'rollup'           => $this->rollup,
            'intervals'        => $this->intervals->toArray(),
        ];
    }
}