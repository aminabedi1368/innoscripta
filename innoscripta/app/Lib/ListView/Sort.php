<?php
namespace App\Lib\ListView;

/**
 * Class Sort
 * @package App\Lib\ListView
 */
class Sort
{

    /**
     * @var string
     */
    private string $field;

    /**
     * @var string
     */
    private string $dir;

    /**
     * Sort constructor.
     * @param string $field
     * @param string $dir
     */
    public function __construct(string $field, string $dir = 'asc')
    {
        $this->field = $field;
        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return Sort
     */
    public function setField(string $field): Sort
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     * @return Sort
     */
    public function setDir(string $dir): Sort
    {
        $this->dir = $dir;
        return $this;
    }

}
