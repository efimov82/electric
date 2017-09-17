<?php
// namespace src;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @Entity @Table(name="users_results")
 **/
class GameResult
{
    
  /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", scale=45)
     */
    protected $scores;


    /** @Column(type="string") **/
    protected $date_create;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}