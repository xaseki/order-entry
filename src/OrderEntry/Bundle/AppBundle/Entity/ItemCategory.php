<?php

namespace OrderEntry\Bundle\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Item
 * @package OrderEntry\Bundle\AppBundle\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OrderEntry\Bundle\AppBundle\Repository\ItemCategoryRepository")
 *
 */
class ItemCategory
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="item", type="string", nullable=false)
     * @Assert\NotBlank(
     *     message="名前を入力してください"
     * )
     * @Assert\Length(
     *     min="1",
     *     minMessage="カテゴリー名は{{ limit }}文字以上でご記入ください",
     *     max="50",
     *     maxMessage="カテゴリー名は{{ limit }}文字以下でご記入ください"
     * )
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=false)
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
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }


    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return $this
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

}