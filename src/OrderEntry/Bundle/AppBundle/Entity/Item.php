<?php
/**
 * Created by PhpStorm.
 * User: xearts
 * Date: 2017/10/17
 * Time: 21:07
 */

namespace OrderEntry\Bundle\AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

class Item
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
     */
    private $name;

    /**
     * @var
     */
    private $photo;

    /**
     * @var integer
     * @ORM\Column(name="price", type="integer", nullable=false)
     * @Assert\NotBlank(
     *     message="金額を入力してください"
     * )
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(name="category", type="string", nullable=false)
     */
    private $category;



    /**
     * @var boolean
     * @ORM\Column(name="status", type="boolean", default=true)
     */
    private $status;

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


}