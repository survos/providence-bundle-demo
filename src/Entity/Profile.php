<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Survos\Providence\XmlModel\XmlProfile;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile extends XmlProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    private XmlProfile $xmlProfile;

    /**
     * @return XmlProfile
     */
    public function getXmlProfile(): XmlProfile
    {
        return $this->xmlProfile;
    }

    /**
     * @param XmlProfile $xmlProfile
     * @return Profile
     */
    public function setXmlProfile(XmlProfile $xmlProfile): Profile
    {
        $this->xmlProfile = $xmlProfile;
        return $this;
    }

    #[ORM\Column(type: 'integer', nullable: true)]
    private $mdeCount;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $uiCount;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $listCount;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $infoUrl;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $displayCount;


}
