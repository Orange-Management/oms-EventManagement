<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\EventManagement\tests\Models;

use Modules\Admin\Models\NullAccount;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventMapper;
use Modules\EventManagement\Models\EventType;
use Modules\EventManagement\Models\ProgressType;
use Modules\Media\Models\Media;
use Modules\Tasks\Models\Task;
use phpOMS\Localization\Money;
use phpOMS\Utils\RnG\Text;

/**
 * @internal
 */
class EventMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\EventManagement\Models\EventMapper
     * @group module
     */
    public function testCRUD() : void
    {
        $event = new Event();

        $event->setType(EventType::SEMINAR);
        $event->name        = 'Eventname';
        $event->description = 'Event description';
        $event->createdBy   = new NullAccount(1);
        $event->setStart(new \DateTime('2000-05-05'));
        $event->setEnd(new \DateTime('2005-05-05'));

        $money = new Money();
        $money->setString('1.23');

        $event->setCosts($money);
        $event->setBudget($money);
        $event->setEarnings($money);

        $task        = new Task();
        $task->title = 'EventTask 1';
        $task->setCreatedBy(new NullAccount(1));

        $task2        = new Task();
        $task2->title = 'EventTask 2';
        $task2->setCreatedBy(new NullAccount(1));

        $event->addTask($task);
        $event->addTask($task2);

        $event->setProgress(11);
        $event->setProgressType(ProgressType::TASKS);

        $media              = new Media();
        $media->createdBy   = new NullAccount(1);
        $media->description = 'desc';
        $media->setPath('some/path');
        $media->size      = 11;
        $media->extension = 'png';
        $media->name      = 'Event Media';
        $event->addMedia($media);

        $id = EventMapper::create($event);
        self::assertGreaterThan(0, $event->getId());
        self::assertEquals($id, $event->getId());

        $eventR = EventMapper::get($event->getId());

        self::assertEquals($event->name, $eventR->name);
        self::assertEquals($event->description, $eventR->description);
        self::assertEquals($event->countTasks(), $eventR->countTasks());
        self::assertEquals($event->getStart()->format('Y-m-d'), $eventR->getStart()->format('Y-m-d'));
        self::assertEquals($event->getEnd()->format('Y-m-d'), $eventR->getEnd()->format('Y-m-d'));
        self::assertEquals($event->getCosts()->getAmount(), $eventR->getCosts()->getAmount());
        self::assertEquals($event->getBudget()->getAmount(), $eventR->getBudget()->getAmount());
        self::assertEquals($event->getEarnings()->getAmount(), $eventR->getEarnings()->getAmount());
        self::assertEquals($event->getProgress(), $eventR->getProgress());
        self::assertEquals($event->getProgressType(), $eventR->getProgressType());

        $expected = $event->getMedia();
        $actual   = $eventR->getMedia();

        self::assertEquals(\end($expected)->name, \end($actual)->name);
    }

    /**
     * @covers Modules\EventManagement\Models\EventMapper
     * @group module
     */
    public function testNewest() : void
    {
        $newest = EventMapper::getNewest(1);

        self::assertCount(1, $newest);
    }

    /**
     * @group volume
     * @group module
     * @coversNothing
     */
    public function testVolume() : void
    {
        for ($i = 1; $i < 100; ++$i) {
            $text = new Text();

            $event = new Event();

            $event->setType(EventType::SEMINAR);
            $event->name        = $text->generateText(\mt_rand(3, 7));
            $event->description = $text->generateText(\mt_rand(20, 100));
            $event->createdBy   = new NullAccount(1);
            $event->setStart(new \DateTime('2000-05-05'));
            $event->setEnd(new \DateTime('2005-05-05'));
            $event->setProgress(\mt_rand(0, 100));
            $event->setProgressType(\mt_rand(0, 4));

            $money = new Money();
            $money->setString('1.23');

            $event->setCosts($money);
            $event->setBudget($money);
            $event->setEarnings($money);

            $id = EventMapper::create($event);
        }
    }
}
