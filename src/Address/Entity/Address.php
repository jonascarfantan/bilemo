<?php

namespace App\Address\Entity;

use App\Address\Repository\AddressRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: AddressRepository::class, readOnly: false)]
class Address
{
    #[Id, Column(type: 'integer'), GeneratedValue]
    private int $id;
    
    #[Column(type: 'integer', nullable: false)]
    private int $city_code;
    
    #[Column(type: 'string', length: 32, nullable: false), ]
    private string $city;
    
    #[Column(type: 'string', length: 32, nullable: false), ]
    private string $street;
    
    #[Column(type: 'string', length: 32, nullable: false)]
    private string $country;
    
    #[Column(type: 'integer', length: 255, nullable: false)]
    private string $street_number;
    
    #[Column(type: 'string', length: 255)]
    private ?string $comp_address;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $created_at;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updated_at;
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getCity(): string {
        return $this->city;
    }
    
    public function setCity(string $city): self {
        $this->city = $city;
        
        return $this;
    }
    
    public function getCityCode(): int {
        return $this->city_code;
    }
    
    public function setCityCode(int $city_code): self {
        $this->city_code = $city_code;
        
        return $this;
    }
    
    public function getStreet(): string {
        return $this->street;
    }
    
    public function setStreet(string $street): self {
        $this->street = $street;
        
        return $this;
    }
    
    public function getCountry(): string {
        return $this->country;
    }
    
    public function setCountry(string $country): self {
        $this->country = $country;
        
        return $this;
    }
    
    public function getStreetNumber(): string {
        return $this->street_number;
    }
    
    public function setStreetNumber(string $street_number): self {
        $this->street_number = $street_number;
        
        return $this;
    }
    
    public function getCompAddress(): ?string {
        return $this->comp_address;
    }
    
    public function setCompAddress(?string $comp_address): self {
        $this->comp_address = $comp_address;
        
        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->created_at;
    }
    
    public function setCreatedAt(?\DateTimeImmutable $created_at): self {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    public function getUpdatedAt(): ?\DateTimeImmutable {
        return $this->updated_at;
    }
    
    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self {
        $this->updated_at = $updated_at;
        
        return $this;
    }
}
