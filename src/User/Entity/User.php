<?php

namespace App\User\Entity;

use App\Address\Entity\Address;
use App\Customer\Entity\Customer;
use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

#[Entity(repositoryClass: UserRepository::class, readOnly: false)]
class User
{
    #[Id, Column(type: 'integer'), GeneratedValue]
    private int $id;
    
    #[
        OneToOne(targetEntity: 'App\Address\Entity\Address', cascade: ["persist", "remove"], orphanRemoval: true),
        JoinColumn(name: 'address_id', referencedColumnName: "id", unique: false)
    ]
    private Address $address;
    
    #[ManyToOne(targetEntity: 'App\Customer\Entity\Customer', inversedBy: 'users')]
    private Customer $customer;
    
    #[Column(type: 'string', length: 32, unique: true, nullable: false) ]
    private string $username;
    
    #[Column(type: 'string', length: 32, nullable: false), ]
    private string $role;
    
    #[Column(type: 'string', length: 32, unique: true, nullable: false)]
    private string $email;
    
    #[Column(type: 'string', length: 32, nullable: false)]
    private string $first_name;
    
    #[Column(type: 'string', length: 32, nullable: false)]
    private string $last_name;
    
    #[Column(type: 'string', length: 255, nullable: false)]
    private string $password;
    
    #[Column(type: 'string', length: 255, nullable: true)]
    private ?string $ForgotPasswordToken;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $ForgotPasswordTokenRequestedAt;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $ForgotPasswordTokenMustBeVerifiedBefore;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $created_at;
    
    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updated_at;
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUsername(): string {
        return $this->username;
    }
    
    public function setUsername(string $username): self {
        $this->username = $username;
        
        return $this;
    }
    
    public function getRole(): string {
        return $this->role;
    }
    
    public function setRole(string $role): self {
        $this->role = $role;
        
        return $this;
    }
    
    public function getEmail(): string {
        return $this->email;
    }
    
    public function setEmail(string $email): self {
        $this->email = $email;
        
        return $this;
    }
    
    public function getFirstName(): string {
        return $this->first_name;
    }
    
    public function setFirstName(string $first_name): self {
        $this->first_name = $first_name;
        
        return $this;
    }
    
    public function getLastName(): string {
        return $this->last_name;
    }
    
    public function setLastName(string $last_name): self {
        $this->last_name = $last_name;
        
        return $this;
    }
    
    public function getPassword(): string {
        return $this->password;
    }
    
    public function setPassword(string $password): self {
        $this->password = $password;
        
        return $this;
    }
    
    public function getForgotPasswordToken(): ?string {
        return $this->ForgotPasswordToken;
    }
    
    public function setForgotPasswordToken(?string $ForgotPasswordToken): self {
        $this->ForgotPasswordToken = $ForgotPasswordToken;
        
        return $this;
    }
    
    public function getForgotPasswordTokenRequestedAt(): ?\DateTimeImmutable {
        return $this->ForgotPasswordTokenRequestedAt;
    }
    
    public function setForgotPasswordTokenRequestedAt(?\DateTimeImmutable $ForgotPasswordTokenRequestedAt): self {
        $this->ForgotPasswordTokenRequestedAt = $ForgotPasswordTokenRequestedAt;
        
        return $this;
    }
    
    public function getForgotPasswordTokenMustBeVerifiedBefore(): ?\DateTimeImmutable {
        return $this->ForgotPasswordTokenMustBeVerifiedBefore;
    }
    
    public function setForgotPasswordTokenMustBeVerifiedBefore(?\DateTimeImmutable $ForgotPasswordTokenMustBeVerifiedBefore): self {
        $this->ForgotPasswordTokenMustBeVerifiedBefore = $ForgotPasswordTokenMustBeVerifiedBefore;
        
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
    
//////////////////////////
/// RELATIONSHIP
//////////////////////
    public function getCustomer(): Customer {
        return $this->customer;
    }
    
    public function setCustomer($customer): self {
        $this->customer = $customer;
        
        return $this;
    }
    
    public function getAddress(): Address {
        return $this->address;
    }
    
    public function setAddress($address): self {
        $this->address = $address;
        
        return $this;
    }
}
