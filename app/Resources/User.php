<?php

namespace App\Resources;

class User
{
    private string $firstName;
    private string $lastName;
    private string $avatar;
    private string $email;

    public function __construct(array $data)
    {
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->avatar = $data['avatar'];
        $this->email = $data['email'];
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'avatar' => $this->avatar,
            'email' => $this->email,
        ];
    }

    public function __get(string $property): ?string
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }
        return null;
    }
}
