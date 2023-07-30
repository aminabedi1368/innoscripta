<?php
namespace App\Entities;

/**
 * Class SettingEntity
 * @package App\Entities
 */
class SettingEntity
{

    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $value;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SettingEntity
     */
    public function setId(?int $id): SettingEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return SettingEntity
     */
    public function setKey(string $key): SettingEntity
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return SettingEntity
     */
    public function setValue(string $value): SettingEntity
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return !empty($this->id);
    }

    /**
     * @return bool
     */
    public function isPersisted()
    {
        return $this->hasId();
    }

    /**
     * @return bool
     */
    public function isNotPersisted()
    {
        return !empty($this->isPersisted());
    }

}
