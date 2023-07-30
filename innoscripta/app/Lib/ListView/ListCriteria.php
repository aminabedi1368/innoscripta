<?php
namespace App\Lib\ListView;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 *
 * Sample url : /people?age=gte.18&student=eq.true&select=first_name,last_name&offset=10&limit=15
 * This sample url should get converted to this class
 *
 * Class ListCriteria
 * @package App\Lib
 */
class ListCriteria
{

    const DESC = 'desc';
    const ASC  = 'asc';

    const OPERATOR_EQUAL = 'eq';
    const OPERATOR_BIGGER = '>';
    const OPERATOR_BIGGER_EQUAL = '>=';
    const OPERATOR_SMALLER = '<';
    const OPERATOR_SMALLER_EQUAL = '<=';
    const OPERATOR_LIKE = 'like';


    const operators = [
        self::OPERATOR_EQUAL,
        self::OPERATOR_BIGGER,
        self::OPERATOR_BIGGER_EQUAL,
        self::OPERATOR_SMALLER,
        self::OPERATOR_SMALLER_EQUAL,
        self::OPERATOR_LIKE,
    ];

    /**
     * @var int
     */
    private int $offset = 0;

    /**
     * @var int
     */
    private int $limit = 10;

    /**
     * @var Sort|null
     */
    protected ?Sort $sort = null;

    /**
     * @var array
     */
    protected array $fields = ['*'];

    /**
     * @var array
     */
    protected array $filters = [];

    /**
     * @var string
     */
    protected string $url;

    /**
     * example:
     * [ q => "stringToSearch", fields => [firstName, lastName, ...] ]
     * @var array
     */
    protected array $search;

    /**
     * @param Request $request
     * @return ListCriteria
     */
    function fromRequest(Request $request): ListCriteria
    {
        return self::fromRequestStatic($request);
    }

    /**
     * @param Request $request
     * @return ListCriteria
     */
    static function fromRequestStatic(Request $request): ListCriteria
    {
        $criteria = new static();

        if($request->has('page') || $request->has('per_page')) {

            $per_page = $request->get('per_page', 10);
            $page = $request->get('page', 1);

            $criteria->setOffset($per_page * ($page - 1));
            $criteria->setLimit($per_page);
        }
        else {
            $criteria->setOffset($request->get('offset', 0));
            $criteria->setLimit($request->get('limit', 10));
        }
        

        $criteria->setFilters(
            self::parseFilters(
                $request->except('offset', 'limit', 'select', 'order', 'paginated', 'tokenInfo')
            )
        );
        $criteria->setFields(self::parseFields($request));
        $criteria->setSort(self::parseSort($request->get('order') ) );
        $criteria->setUrl($request->getRequestUri());

        return $criteria;
    }

    public static function parseFields(Request $request)
    {
        $fields = $request->get('select');

        if(is_array($fields)) {
            return $fields;
        }
        elseif (is_string($fields)) {
            return explode(',', $fields);
        }
        else {
            return ['*'];
        }
    }


    /**
     * @param string|null $sort
     * @return Sort|null
     */
    static function parseSort(string $sort = null): ?Sort
    {
        ### sample : age.asc | age.desc
        if(!is_null($sort)) {
            if(str_contains($sort, '.')) {
                $parts = explode('.', $sort);
                $field = $parts[0];
                $direction = $parts[1];
            }
            else {
                $field = $sort;
                $direction = 'asc';
            }
            return new Sort($field, $direction);
        }

        return null;
    }

    /**
     * @param array $filters
     * @return array
     */
    static function parseFilters(array $filters): array
    {
        $result = [];

        foreach ($filters as $fKey => $fValue) {
            $operator = self::detectOperator($fValue);
            $actualValue = explode('.', $fValue)[1];

            $result[] = (new QueryFilter())
                ->setField($fKey)
                ->setOperator($operator)
                ->setValue($actualValue);
        }

        return $result;
    }


    /**
     * This function takes a string as argument
     * and check if this string starts with one of our operators if yes, it returns the operator
     * else it returns null
     *
     * @param $str
     * @return string | null
     */
    static function detectOperator(string $str): ?string
    {
        foreach (self::operators as $operator) {
            if(Str::startsWith($str, $operator)) {
                return $operator;
            }
        }

        return null;
    }


    /**
     * @param Sort|null $sort
     * @return ListCriteria
     */
    public function setSort(Sort $sort = null): ListCriteria
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return ListCriteria
     */
    public function setOffset(int $offset): ListCriteria
    {
        $this->offset = $offset;
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
     * @return ListCriteria
     */
    public function setLimit(int $limit): ListCriteria
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return Sort|null
     */
    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    /**
     * @param array $fields
     * @return ListCriteria
     */
    public function setFields(array $fields): ListCriteria
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFilters(): ?array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return ListCriteria
     */
    public function setFilters(array $filters): ListCriteria
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * [
     *       'key'      => $fKey,
     *       'operator' => self::OPERATOR_EQUAL,
     *       'operands' => [ $fValue]
     * ];
     *
     * @param array $filter
     * @return ListCriteria
     */
    public function addFilter(array $filter): ListCriteria
    {
        $this->filters[] = $filter;

        return $this;
    }


    /**
     * @param string $url
     * @return ListCriteria
     */
    public function setUrl(string $url): ListCriteria
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


    /**
     * @param $data
     * @return bool
     */
    public static function is_int_val($data): bool
    {
        if (is_int($data) === true) return true;
        if (is_string($data) === true && is_numeric($data) === true) {
            return (strpos($data, '.') === false);
        }
    }

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }


}
