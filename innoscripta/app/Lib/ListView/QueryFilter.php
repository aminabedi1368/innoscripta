<?php
namespace App\Lib\ListView;

/**
 * Class QueryFilter
 * @package App\Lib\ListView
 */
class QueryFilter
{

    /**
     * @var string
     */
    private string $field;

    /**
     * @var string
     */
    private string $operator;

    /**
     * @var
     */
    private $value;

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return QueryFilter
     */
    public function setField(string $field): QueryFilter
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     * @return QueryFilter
     */
    public function setOperator(string $operator): QueryFilter
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return QueryFilter
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }


}

