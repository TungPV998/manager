<?php

namespace App\Criteria;


use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RequestCriteria
 * @package Prettus\Repository\Criteria
 * @author Anderson Andrade <contato@andersonandra.de>
 */
abstract class AbstractRequestCriteria extends RequestCriteria
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $search;
    protected $searchFields;
    protected $filter;
    protected $sortedBy;
    protected $orderBy;
    protected $with;
    protected $withCount;
    protected $searchJoin;
    protected $forceFieldsSearchable = [];
    protected $searchFieldsByKeyword = [];

    public function __construct(array $searchData = [])
    {
        $this->search = Arr::get($searchData, config('repository.criteria.params.search', 'search', null));
        $this->searchFields = Arr::get($searchData, config('repository.criteria.params.searchFields', 'searchFields'), null);
        $this->filter = Arr::get($searchData, config('repository.criteria.params.filter', 'filter'), null);
        $this->orderBy = Arr::get($searchData, config('repository.criteria.params.orderBy', 'orderBy'), null);
        $this->with = Arr::get($searchData, config('repository.criteria.params.with', 'with'), null);
        $this->withCount = Arr::get($searchData, config('repository.criteria.params.withCount', 'withCount'), null);
        $this->searchJoin = Arr::get($searchData, config('repository.criteria.params.searchJoin', 'searchJoin'), null);
        $sortedBy = Arr::get($searchData, config('repository.criteria.params.sortedBy', 'sortedBy'), 'asc');
        $this->sortedBy = !empty($sortedBy) ? $sortedBy : 'asc';
        $this->forceFieldsSearchable = $searchData['forceFieldsSearchable'] ?? '';
        $this->searchFieldsByKeyword = $searchData['searchFieldsByKeyword'] ?? [];
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fieldsSearchable = is_array($this->forceFieldsSearchable) && count($this->forceFieldsSearchable) ? $this->forceFieldsSearchable : $repository->getFieldsSearchable();
        $search = $this->search;
        $searchFields = $this->searchFields;
        $filter = $this->filter;
        $sortedBy = $this->sortedBy;
        $orderBy = $this->orderBy;
        $with = $this->with;
        $withCount = $this->withCount;
        $searchJoin = $this->searchJoin;
        if ($search && is_array($fieldsSearchable) && count($fieldsSearchable)) {
            $searchFields = is_array($searchFields) || is_null($searchFields) ? $searchFields : explode(';', $searchFields);
            $fields = $this->parserFieldsSearch($fieldsSearchable, $searchFields);
            $isFirstField = true;
            $searchData = $this->parserSearchData($search);
            $search = $this->parserSearchValue($search);
            $modelForceAndWhere = strtolower($searchJoin) === 'and';
            //Tao condition theo keyword
            if (trim($search) != '' && count($this->searchFieldsByKeyword) > 0)
                $model = $this->buildConditionByKeyword($model, $search, $this->searchFieldsByKeyword);
            //Tao condition theo
            $model = $model->where(function ($query) use ($fields, $search, $searchData, $isFirstField, $modelForceAndWhere) {
                foreach ($fields as $field => $condition) {
                    if (is_numeric($field)) {
                        $field = $condition;
                        $condition = "=";
                    }

                    $condition = trim(strtolower($condition));

                    $value = null;
                    if (isset($searchData[$field])) {
                        $value = ($condition == "like" || $condition == "ilike") ? "%{$searchData[$field]}%" : $searchData[$field];
                    }
                    if (is_null(is_null($value)))
                        continue;

                    //Tao condition de len condition default
                    if (in_array($field, get_class_methods($this))) {
                        $query = $this->{$field}($query, $value, $condition);
                        continue;
                    }

                    $relation = null;
                    if (stripos($field, '.')) {
                        $explode = explode('.', $field);
                        $field = array_pop($explode);
                        $relation = implode('.', $explode);
                    }
                    $modelTableName = $query->getModel()->getTable();

                    if ($isFirstField || $modelForceAndWhere) {
                        if (!is_null($value)) {
                            if (!is_null($relation)) {
                                $query->whereHas($relation, function ($query) use ($field, $condition, $value) {
                                    $query->where($field, $condition, $value);
                                });
                            } else {
                                $query->where($modelTableName . '.' . $field, $condition, $value);
                            }
                            $isFirstField = false;
                        }
                    } else {
                        if (!is_null($value)) {
                            if (!is_null($relation)) {
                                $query->orWhereHas($relation, function ($query) use ($field, $condition, $value) {
                                    $query->where($field, $condition, $value);
                                });
                            } else {
                                $query->orWhere($modelTableName . '.' . $field, $condition, $value);
                            }
                        }
                    }
                }
            });
        }

        if (isset($orderBy) && !empty($orderBy)) {
            $orderBySplit = explode(';', $orderBy);
            if (count($orderBySplit) > 1) {
                $sortedBySplit = explode(';', $sortedBy);
                foreach ($orderBySplit as $orderBySplitItemKey => $orderBySplitItem) {
                    $sortedBy = isset($sortedBySplit[$orderBySplitItemKey]) ? $sortedBySplit[$orderBySplitItemKey] : $sortedBySplit[0];
                    $model = $this->parserFieldsOrderBy($model, $orderBySplitItem, $sortedBy);
                }
            } else {
                $model = $this->parserFieldsOrderBy($model, $orderBySplit[0], $sortedBy);
            }
        }

        if (isset($filter) && !empty($filter)) {
            if (is_string($filter)) {
                $filter = explode(';', $filter);
            }

            $model = $model->select($filter);
        }

        if ($with) {
            $with = explode(';', $with);
            $model = $model->with($with);
        }

        if ($withCount) {
            $withCount = explode(';', $withCount);
            $model = $model->withCount($withCount);
        }
        return $model;
    }


    /**
     * @param $model
     * @param $orderBy
     * @param $sortedBy
     * @return mixed
     */
    protected function parserFieldsOrderBy($model, $orderBy, $sortedBy)
    {
        $split = explode('|', $orderBy);
        if (count($split) > 1) {
            /*
             * ex.
             * products|description -> join products on current_table.product_id = products.id order by description
             *
             * products:custom_id|products.description -> join products on current_table.custom_id = products.id order
             * by products.description (in case both tables have same column name)
             */
            $table = $model->getModel()->getTable();
            $sortTable = $split[0];
            $sortColumn = $split[1];

            $split = explode(':', $sortTable);
            if (count($split) > 1) {
                $sortTable = $split[0];
                $keyName = $table . '.' . $split[1];
            } else {
                /*
                 * If you do not define which column to use as a joining column on current table, it will
                 * use a singular of a join table appended with _id
                 *
                 * ex.
                 * products -> product_id
                 */
                $prefix = Str::singular($sortTable);
                $keyName = $table . '.' . $prefix . '_id';
            }

            $model = $model
                ->leftJoin($sortTable, $keyName, '=', $sortTable . '.id')
                ->orderBy($sortColumn, $sortedBy)
                ->addSelect($table . '.*');
        } else {
            $model = $model->orderBy($orderBy, $sortedBy);
        }
        return $model;
    }

    /**
     * @param $search
     *
     * @return array
     */
    protected function parserSearchData($search)
    {
        $searchData = [];

        if (stripos($search, ':')) {
            $fields = explode(';', $search);

            foreach ($fields as $row) {
                try {
                    list($field, $value) = explode(':', $row);
                    $searchData[$field] = $value;
                } catch (\Exception $e) {
                    //Surround offset error
                }
            }
        }

        return $searchData;
    }

    /**
     * @param $search
     *
     * @return null
     */
    protected function parserSearchValue($search)
    {

        if (stripos($search, ';') || stripos($search, ':')) {
            $values = explode(';', $search);
            foreach ($values as $value) {
                $s = explode(':', $value);
                if (count($s) == 1) {
                    return $s[0];
                }
            }

            return null;
        }

        return $search;
    }


    protected function parserFieldsSearch(array $fields = [], array $searchFields = null)
    {
        if (!is_null($searchFields) && count($searchFields)) {
            $acceptedConditions = config('repository.criteria.acceptedConditions', [
                '=',
                'like'
            ]);
            $originalFields = $fields;
            $fields = [];

            foreach ($searchFields as $index => $field) {
                $field_parts = explode(':', $field);
                $temporaryIndex = array_search($field_parts[0], $originalFields);
                if (count($field_parts) == 2) {
                    if (in_array($field_parts[1], $acceptedConditions)) {
                        unset($originalFields[$temporaryIndex]);
                        $field = $field_parts[0];
                        $condition = $field_parts[1];
                        $originalFields[$field] = $condition;
                        $searchFields[$index] = $field;
                    }
                }
            }

            foreach ($originalFields as $field => $condition) {
                if (is_numeric($field)) {
                    $field = $condition;
                    $condition = "=";
                }
                if (in_array($field, $searchFields)) {
                    $fields[$field] = $condition;
                }
            }

            if (count($fields) == 0) {
                throw new \Exception(trans('repository::criteria.fields_not_accepted', ['field' => implode(',', $searchFields)]));
            }

        }

        return $fields;
    }

    protected function buildConditionByKeyword($model, $search, $fields)
    {
        $isFirstField = true;
        $model = $model->where(function ($query) use ($fields, $search, $isFirstField) {
            foreach ($fields as $field => $condition) {
                if (is_numeric($field)) {
                    $field = $condition;
                    $condition = "=";
                }
                $condition = trim(strtolower($condition));
                $value = ($condition == "like" || $condition == "ilike") ? "%{$search}%" : $search;

                $relation = null;
                if (stripos($field, '.')) {
                    $explode = explode('.', $field);
                    $field = array_pop($explode);
                    $relation = implode('.', $explode);
                }
                $modelTableName = $query->getModel()->getTable();

                if ($isFirstField) {
                    if (!is_null($value)) {
                        if (!is_null($relation)) {
                            $query->whereHas($relation, function ($query) use ($field, $condition, $value) {
                                $query->where($field, $condition, $value);
                            });
                        } else {
                            $query->where($modelTableName . '.' . $field, $condition, $value);
                        }
                        $isFirstField = false;
                    }
                } else {
                    if (!is_null($value)) {
                        if (!is_null($relation)) {
                            $query->orWhereHas($relation, function ($query) use ($field, $condition, $value) {
                                $query->where($field, $condition, $value);
                            });
                        } else {
                            $query->orWhere($modelTableName . '.' . $field, $condition, $value);
                        }
                    }
                }
            }
        });
        return $model;
    }
}
