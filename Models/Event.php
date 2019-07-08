<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\EventManagement\Models
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\EventManagement\Models;

use Modules\Calendar\Models\Calendar;
use Modules\Tasks\Models\Task;
use phpOMS\Localization\Money;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

/**
 * Event class.
 *
 * @package    Modules\EventManagement\Models
 * @license    OMS License 1.0
 * @link       https://orange-management.org
 * @since      1.0.0
 */
class Event
{

    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    private $type = EventType::DEFAULT;

    private $start = null;

    private $end = null;

    private $name = '';

    private $description = '';

    private $calendar = null;

    private $costs = null;

    private $budget = null;

    private $earnings = null;

    private $tasks = [];

    private $media = [];

    private $progress = 0;

    private $progressType = ProgressType::MANUAL;

    /**
     * Created.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $createdAt = null;

    /**
     * Creator.
     *
     * @var int
     * @since 1.0.0
     */
    private $createdBy = 0;

    public function __construct(string $name = '')
    {
        $this->start     = new \DateTime('now');
        $this->end       = (new \DateTime('now'))->modify('+1 month');
        $this->calendar  = new Calendar();
        $this->costs     = new Money();
        $this->budget    = new Money();
        $this->earnings  = new Money();
        $this->createdAt = new \DateTime('now');

        $this->setName($name);
    }

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia($media) : void
    {
        $this->media[] = $media;
    }

    public function getStart() : \DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start) : void
    {
        $this->start = $start;
    }

    public function setEnd(\DateTime $end) : void
    {
        $this->end = $end;
    }

    public function getEnd() : \DateTime
    {
        return $this->end;
    }

    public function getProgress() : int
    {
        return $this->progress;
    }

    public function setProgress(int $progress) : void
    {
        $this->progress = $progress;
    }

    public function getProgressType() : int
    {
        return $this->progressType;
    }

    public function setProgressType(int $type) : void
    {
        $this->progressType = $type;
    }

    public function getCalendar() : Calendar
    {
        return $this->calendar;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function addTask(Task $task) : void
    {
        if ($task->getId() !== 0) {
            $this->tasks[$task->getId()] = $task;
        } else {
            $this->tasks[] = $task;
        }
    }

    public function removeTask(int $id) : bool
    {
        if (isset($this->tasks[$id])) {
            unset($this->tasks[$id]);

            return true;
        }

        return false;
    }

    public function getTask(int $id) : Task
    {
        return $this->tasks[$id] ?? new Task();
    }

    public function getTasks() : array
    {
        return $this->tasks;
    }

    public function countTasks() : int
    {
        return \count($this->tasks);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setType(int $type) : void
    {
        if (!EventType::isValidValue($type)) {
            throw new InvalidEnumValue($type);
        }

        $this->type = $type;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function getCosts() : Money
    {
        return $this->costs;
    }

    public function getBudget() : Money
    {
        return $this->budget;
    }

    public function getEarnings() : Money
    {
        return $this->earnings;
    }

    public function setCosts(Money $costs) : void
    {
        $this->costs = $costs;
    }

    public function setBudget(Money $budget) : void
    {
        $this->budget = $budget;
    }

    public function setEarnings(Money $earnings) : void
    {
        $this->earnings = $earnings;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getCreatedBy() : int
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy Creator
     *
     * @since  1.0.0
     */
    public function setCreatedBy(int $createdBy) : void
    {
        $this->createdBy = $createdBy;
    }
}
