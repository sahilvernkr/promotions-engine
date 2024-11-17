<?php

namespace App\Tests\Unit;

use App\Tests\ServiceTestCase;
use App\DTO\LowestPriceEnquiry;
use App\Service\ServiceException;
use App\Event\AfterDtoCreatedEvent;
use App\EventSubscriber\DtoSubscriber;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DtoSubscriberTest extends ServiceTestCase
{
    /** @test */
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(AfterDtoCreatedEvent::NAME, DtoSubscriber::getSubscribedEvents());
    }

    /** @test */
    public function testValidateDto(): void
    {
        // Given
        $dto = new LowestPriceEnquiry();
        $dto->setQuantity(-5);

        $event = new AfterDtoCreatedEvent($dto);

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');

        //expect
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('validation failed');

        //when
        $eventDispatcher->dispatch($event, $event::NAME);
    }
}
