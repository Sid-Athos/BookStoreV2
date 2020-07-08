<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Rentals::class, mappedBy="client")
     */
    private $order;

    public function __construct()
    {
        $this->order = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Rentals[]
     */
    public function getOrders(): Collection
    {
        return $this->order;
    }

    public function addOrders(Orders $order): self
    {
        if (!$this->order->contains($order)) {
            $this->order[] = $order;
            $order->setClient($this);
        }

        return $this;
    }

    public function removeOrders(Orders $order): self
    {
        if ($this->order->contains($order)) {
            $this->order->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getClient() === $this) {
                $order->setClient(null);
            }
        }

        return $this;
    }

    public function buildForm(){
        $form = $this->createFormBuilder($Client)
            ->add('last_name', TextType::class)
            ->add('first_name', TextType::class)
            ->add('address', TextType::class)
            ->add('post_code', TextType::class)
            ->add('city', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

            return $form;
    }

    public function getFullName(){
        return $this->lastName.' '.$this->firstName;
    }
}
