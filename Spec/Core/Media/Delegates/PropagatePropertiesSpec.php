<?php

namespace Spec\Minds\Core\Media\Delegates;

use Minds\Entities\Activity;
use Minds\Entities\Image;
use PhpSpec\ObjectBehavior;

class PropagatePropertiesSpec extends ObjectBehavior
{
    /** @var Image */
    protected $entity;
    /** @var Activity */
    protected $activity;

    public function let(
        Image $entity,
        Activity $activity
    ) {
        $this->entity = $entity;
        $this->activity = $activity;
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Minds\Core\Media\Delegates\PropagateProperties');
    }

    public function it_should_propagate_changes_to_activity()
    {
        $this->entity->get('title')->shouldBeCalled()->willReturn('new title');
        $this->activity->getMessage()->shouldBeCalled()->willReturn('old title');
        $this->activity->setMessage('new title')->shouldBeCalled();

        $activityParameters = [
            'batch',
            [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        ];

        $this->entity->getActivityParameters()->shouldBeCalled()->willReturn($activityParameters);
        $this->activity->getCustom()->shouldBeCalled()->willReturn([]);
        $this->activity->setCustom($activityParameters[0], $activityParameters[1])->shouldBeCalled();

        $this->toActivity($this->entity, $this->activity);
    }

    public function it_should_propogate_properties_from_activity()
    {
        $this->activity->getMessage()->shouldBeCalled()->willReturn('new title');
        $this->entity->get('title')->shouldbeCalled()->willReturn('old title');
        $this->entity->set('title', 'new title')->shouldBeCalled();

        $this->fromActivity($this->activity, $this->entity);
    }
}
