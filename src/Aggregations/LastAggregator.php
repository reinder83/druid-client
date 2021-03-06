<?php
declare(strict_types=1);

namespace Level23\Druid\Aggregations;

class LastAggregator extends MethodAggregator
{
    /**
     * Returns the method for the type aggregation
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return 'last';
    }
}