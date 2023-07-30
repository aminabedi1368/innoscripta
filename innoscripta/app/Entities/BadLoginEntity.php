<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Class BadLoginEntity
 * @package App\Entities
 */
class BadLoginEntity
{

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $login_type;

    /**
     * @var string|null
     */
    private ?string $device_type = null;

    /**
     * @var string|null
     */
    private ?string $os_type = null;

    /**
     * @var string|null
     */
    private ?string $ip = null;

    /**
     * @var int|null
     */
    private ?int $user_identifier_id = null;

    /**
     * @var Carbon
     */
    private Carbon $created_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return BadLoginEntity
     */
    public function setId(int $id): BadLoginEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return BadLoginEntity
     */
    public function setUsername(?string $username): BadLoginEntity
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return BadLoginEntity
     */
    public function setPassword(string $password): BadLoginEntity
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoginType(): string
    {
        return $this->login_type;
    }

    /**
     * @param string $login_type
     * @return BadLoginEntity
     */
    public function setLoginType(string $login_type): BadLoginEntity
    {
        $this->login_type = $login_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->device_type;
    }

    /**
     * @param string|null $device_type
     * @return BadLoginEntity
     */
    public function setDeviceType(?string $device_type): BadLoginEntity
    {
        $this->device_type = $device_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOsType(): ?string
    {
        return $this->os_type;
    }

    /**
     * @param string|null $os_type
     * @return BadLoginEntity
     */
    public function setOsType(?string $os_type): BadLoginEntity
    {
        $this->os_type = $os_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return BadLoginEntity
     */
    public function setIp(?string $ip): BadLoginEntity
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserIdentifierId(): ?int
    {
        return $this->user_identifier_id;
    }

    /**
     * @param int|null $user_identifier_id
     * @return BadLoginEntity
     */
    public function setUserIdentifierId(?int $user_identifier_id): BadLoginEntity
    {
        $this->user_identifier_id = $user_identifier_id;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @param Carbon $created_at
     * @return BadLoginEntity
     */
    public function setCreatedAt(Carbon $created_at): BadLoginEntity
    {
        $this->created_at = $created_at;
        return $this;
    }



}
