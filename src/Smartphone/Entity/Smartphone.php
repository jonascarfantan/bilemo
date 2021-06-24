<?php

namespace App\Smartphone\Entity;

use App\Smartphone\Repository\SmartphoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;

class Smartphone
{
    private int $id;
    

    private int $detail;
    
    
    private string $brand;
    
    
    private string $model;
    
    
    private ?\DateTimeInterface $created_at;
    
    
    private \DateTime $updated_at;
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getDetail(): string {
        return $this->detail;
    }
    
    public function setDetail(string $city): self {
        $this->detail = $city;
        
        return $this;
    }
    
    public function getBrand(): int {
        return $this->brand;
    }
    
    public function setBrand(int $city_code): self {
        $this->brand = $city_code;
        
        return $this;
    }
    
    public function getModel(): string {
        return $this->model;
    }
    
    public function setModel(string $street): self {
        $this->model = $street;
        
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
