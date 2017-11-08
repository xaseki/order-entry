<?php

/**
 * Created by PhpStorm.
 * User: xearts
 * Date: 2017/10/14
 * Time: 14:39
 */

namespace OrderEntry\Bundle\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type = "string", nullable=false)
     * @Assert\NotBlank(
     *  message="フリガナを入力してください",
     *  groups={"MyRegistration", "MyProfile"}
     * )
     * @Assert\Length(
     *  min=1,
     *  minMessage="フリガナが短すぎます",
     *  max=100,
     *  maxMessage="フリガナは{{ limit }}文字以内で入力してください",
     *  groups={"MyRegistration", "MyProfile"}
     * )
     * @Assert\Regex(
     *  pattern="/^[ァ-ヶーー\s]+$/u",
     *  message="フリガナはカタカナのみで入力してください",
     *  groups={"Registration", "Profile"}
     * )
     */
    private $kana;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message="お名前を入力してください",
     *     groups={"Registration", "Profile"}
     * )
     * @Assert\Length(
     *     min="1",
     *     minMessage="お名前が短すぎます",
     *     max="255",
     *     maxMessage="お名前は{{ limit }}文字以内で入力してください",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;


    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKana()
    {
        return $this->kana;
    }

    /**
     * @param string $kana
     * @return $this
     */
    public function setKana($kana)
    {
        $this->kana = $kana;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}