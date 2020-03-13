<?php
declare(strict_types=1);

namespace App\Application\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies")
 */
class Company
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
    private $externalAppId;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Team", mappedBy="company", cascade={"ALL"})
     */
    private $teams;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExternalAppId(): string
    {
        return $this->externalAppId;
    }

    /**
     * @param string $externalAppId
     */
    public function setExternalAppId(string $externalAppId): void
    {
        $this->externalAppId = $externalAppId;
    }

    /**
     * @return Collection
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    /**
     * @param Collection $teams
     */
    public function setTeams(Collection $teams): void
    {
        $this->teams = $teams;
    }


}
