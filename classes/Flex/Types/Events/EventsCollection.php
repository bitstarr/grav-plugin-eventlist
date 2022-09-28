<?php

declare(strict_types=1);

namespace Grav\Plugin\Eventlist\Flex\Types\Events;

use Grav\Common\Flex\Types\Generic\GenericCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class EventsCollection
 * @package Grav\Common\Flex\Generic
 *
 * @extends FlexCollection<string,GenericObject>
 */
class EventsCollection extends GenericCollection
{
    // custom filter for multiple values of the same key
    public function filterByArray( $key, $array ): EventsCollection
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        // https://www.doctrine-project.org/projects/doctrine-collections/en/1.6/expressions.html#orwhere

        foreach ( $array as $item ) {
            $criteria->orWhere( $expr->eq( $key, $item ) );
        }

        return $this->matching( $criteria );
    }

    // custom filter to get all future events
    public function forthcoming( $date = null ): EventsCollection
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        // https://www.doctrine-project.org/projects/doctrine-collections/en/1.6/expressions.html#orwhere

        if ( $date )
        {
            $date = new \DateTime( $date );
        }
        else
        {
            $date = new \DateTime();
            $date->modify( 'last week' );
        }

        $criteria
            ->andWhere( $expr->eq( 'published', true ) )
            ->andWhere( $expr->gte( 'start', $date->format("Y-m-d") ) )
            ->orderBy( [ 'start' => Criteria::ASC ] );

        return $this->matching( $criteria );
    }
}
