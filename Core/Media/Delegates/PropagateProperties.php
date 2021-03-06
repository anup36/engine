<?php

namespace Minds\Core\Media\Delegates;

use Minds\Core\Entities\Propagator\Properties;
use Minds\Entities\Activity;

/**
 * Class PropagateProperties
 * @package Minds\Core\Media\Delegates
 */
class PropagateProperties extends Properties
{
    protected $actsOnType = ['object'];
    protected $actsOnSubtype = ['image', 'video'];

    /**
     * Propagate Entity properties to activity
     * @param $from
     * @param Activity $to
     * @return Activity
     */
    public function toActivity($from, Activity $to): Activity
    {
        if ($this->valueHasChanged($from->title, $to->getMessage())) {
            $to->setMessage($from->title);
        }

        $fromData = $from->getActivityParameters();
        $toData = $to->getCustom();
        if ((!isset($toData[1])) || (isset($toData[1]) && $this->valueHasChanged($fromData[1], $toData[1]))) {
            $to->setCustom($fromData[0], $fromData[1]);
        }

        return $to;
    }

    /**
     * Propagate activity properties to entity
     * @param Activity $from
     * @param $to
     * @return mixed
     */
    public function fromActivity(Activity $from, $to)
    {
        if ($this->valueHasChanged($from->getMessage(), $to->title)) {
            $to->title = $from->getMessage();
        }

        return $to;
    }
}
