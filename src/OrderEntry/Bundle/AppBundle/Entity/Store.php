<?php

namespace OrderEntry\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Store
 * @package OrderEntry\Bundle\AppBundle\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OrderEntry\Bundle\AppBundle\Repository\StoreRepository")
 */
class Store
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="店舗名を入力してください")
     * @Assert\Length(
     *     min="1",
     *     minMessage="店舗名は{limit}文字以上で入力してください"
     * )
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="スラッグを入力してください")
     * @Assert\Length(
     *     min="2",
     *     minMessage="スラッグは{{ limit }}文字以上で入力してください",
     *     max="50",
     *     maxMessage="スラッグは{{ limit }}文字以下で入力してください"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z0-9-_]{2,}$/",
     *     message="スラッグは半角英数字で入力してください"
     * )
     */
    private $slug;

    /**
     * @var ItemCategory
     * @ORM\ManyToOne(targetEntity="ItemCategory")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * })
     *
     */
    private $item;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return ItemCategory
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param ItemCategory $item
     */
    public function setItem(ItemCategory $item)
    {
        $this->item = $item;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
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
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}