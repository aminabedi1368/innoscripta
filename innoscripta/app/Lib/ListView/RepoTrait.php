<?php
namespace App\Lib\ListView;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait RepoTrait
 * @package App\Lib
 */
trait RepoTrait
{

    /**
     * @param Builder $query_builder
     * @param ListCriteria $listCriteria
     * @param Model $model
     * @return Builder
     */
    public function buildFiltersQuery(Builder $query_builder, ListCriteria $listCriteria, Model $model): Builder
    {
        $filters = $listCriteria->getFilters();

        foreach ($filters as $filter) {
            $query_builder = $this->buildSingleFilterQuery($query_builder, $filter, $model);
        }

        return $query_builder;
    }


    /**
     * @param Builder $query_builder
     * @param QueryFilter $queryFilter
     * @param Model $model
     * @return Builder
     */
    private function buildSingleFilterQuery(Builder $query_builder, QueryFilter $queryFilter, Model $model): Builder
    {
        $filterMap = [
            "eq" => "=",
            "gt" => '>',
            "gte" => ">=",
            "lt" => "<",
            "lte" => "<=",
            "like" => "like"
        ];

        $eloquentOperator = $filterMap[$queryFilter->getOperator()];

        $value = $queryFilter->getValue();
        if($queryFilter->getOperator() === "like") {
            $value = "%$value%";
        }
        return $query_builder->where($queryFilter->getField(), $eloquentOperator, $value);
    }

    /**
     * @param Builder $query_builder
     * @param ListCriteria $listCriteria
     * @param Model $model
     * @return Builder
     */
    public function buildSortQuery(Builder $query_builder, ListCriteria $listCriteria, Model $model): Builder
    {
        $sort = $listCriteria->getSort();
        if($sort) {
            return $query_builder->orderBy($sort->getField(), $sort->getDir());
        }
        return $query_builder;
    }


    /**
     * @param Builder $query_builder
     * @param array $fields
     * @param Model $model
     * @return Builder
     */
    public function buildFieldsQuery(Builder $query_builder, array $fields, Model $model): Builder
    {
        return $query_builder->select($fields);
    }

    /**
     * @param ListCriteria $list_criteria
     * @param Model $model
     * @return PaginatedEntityList
     */
    public function makePaginatedList(ListCriteria $list_criteria, Model $model): PaginatedEntityList
    {
        $query = $model->newQuery();

        $query = $this->buildFiltersQuery($query, $list_criteria, $model);
        $query = $this->buildSortQuery($query, $list_criteria, $model);
        $query = $this->buildFieldsQuery($query, $list_criteria->getFields(), $model);

        return (new PaginatedEntityList())
            ->setTotal($query->count())
            ->setLimit($list_criteria->getLimit())
            ->setOffset($list_criteria->getOffset())
            ->setItems($query->offset($list_criteria->getOffset())->take($list_criteria->getLimit())->get()->toArray());
    }

}
