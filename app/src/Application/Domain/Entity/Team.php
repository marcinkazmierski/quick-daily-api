<?php
declare(strict_types=1);

namespace App\Application\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="teams")
 */
class Team
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default": ""})
     */
    private $image = '';

    /**
     * Many Teams have Many Users.
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="teams")
     */
    private $users;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="teams")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * Team constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


}
