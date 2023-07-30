<?php
namespace App\Lib\ListView;

use Closure;

/**
 * Class PaginatedEntityList
 * @package App\Lib\ListView
 */
class PaginatedEntityList
{

    /**
     * @var int
     */
    private int $offset;

    /**
     * @var int
     */
    private int $limit;

    /**
     * @var int
     */
    private int $page;

    /**
     * @var array
     */
    private array $items;

    /**
     * @var int
     */
    private int $total;

    /**
     * @var Closure|null
     */
    private ?Closure $itemsToArrayFunction = null;

    /**
     * @return string
     */
    public function getOffset(): string
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return PaginatedEntityList
     */
    public function setOffset(int $offset): PaginatedEntityList
    {
        $this->offset = $offset;

        $this->page = floor($this->offset/$this->limit) + 1;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return PaginatedEntityList
     */
    public function setLimit(int $limit): PaginatedEntityList
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return PaginatedEntityList
     */
    public function setItems(array $items): PaginatedEntityList
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return PaginatedEntityList
     */
    public function setTotal(int $total): PaginatedEntityList
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return string
     */
    public function getRange(): string
    {
        $offset = $this->offset;
        $end = min($this->offset + $this->limit, $this->total);
        $total = $this->total;

        return "$offset-$end/$total";
    }

    /**
     * @param Closure $function
     */
    public function setItemsToArrayFunction(Closure $function)
    {
        $this->itemsToArrayFunction = $function;
    }

    /**
     * @param bool $withMetaData
     * @return array
     */
    public function toArray(bool $withMetaData = false): array
    {
        $items = $this->itemsToArrayFunction ? $this->itemsToArrayFunction->call($this, $this->items) : $this->items;

        if($withMetaData) {
            return [
                'meta' => [
                    'offset' => $this->offset,
                    'limit' => $this->limit,
                    'total' => $this->total
                ],
                'data' => $items
            ];
        }
        else {
            return $items;
        }

    }


}
