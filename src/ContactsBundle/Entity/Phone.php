<?php

namespace ContactsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ContactsBundle\Entity\PhoneRepository")
 */
class Phone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="home", type="string", length=100)
     */
    private $home;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=100)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="work", type="string", length=100)
     */
    private $work;
    
    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="phones")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $person;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set home
     *
     * @param string $home
     * @return Phone
     */
    public function setHome($home)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home
     *
     * @return string 
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return Phone
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set work
     *
     * @param string $work
     * @return Phone
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * Get work
     *
     * @return string 
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * Set person
     *
     * @param \ContactsBundle\Entity\Person $person
     * @return Phone
     */
    public function setPerson(\ContactsBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \ContactsBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
