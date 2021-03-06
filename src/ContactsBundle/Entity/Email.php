<?php

namespace ContactsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ContactsBundle\Entity\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="main_email", type="string", length=100)
     */
    private $mainEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="work_email", type="string", length=100)
     */
    private $workEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="second_email", type="string", length=100)
     */
    private $secondEmail;
    
    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="emails")
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
     * Set mainEmail
     *
     * @param string $mainEmail
     * @return Email
     */
    public function setMainEmail($mainEmail)
    {
        $this->mainEmail = $mainEmail;

        return $this;
    }

    /**
     * Get mainEmail
     *
     * @return string 
     */
    public function getMainEmail()
    {
        return $this->mainEmail;
    }

    /**
     * Set workEmail
     *
     * @param string $workEmail
     * @return Email
     */
    public function setWorkEmail($workEmail)
    {
        $this->workEmail = $workEmail;

        return $this;
    }

    /**
     * Get workEmail
     *
     * @return string 
     */
    public function getWorkEmail()
    {
        return $this->workEmail;
    }

    /**
     * Set secondEmail
     *
     * @param string $secondEmail
     * @return Email
     */
    public function setSecondEmail($secondEmail)
    {
        $this->secondEmail = $secondEmail;

        return $this;
    }

    /**
     * Get secondEmail
     *
     * @return string 
     */
    public function getSecondEmail()
    {
        return $this->secondEmail;
    }

    /**
     * Set person
     *
     * @param \ContactsBundle\Entity\Person $person
     * @return Email
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
