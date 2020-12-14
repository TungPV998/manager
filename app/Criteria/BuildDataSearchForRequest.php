<?php

namespace App\Criteria;


use Illuminate\Http\Request;

/**
 * Class BuildDataSearchForRequest
 *
 * Class convert data request từ url sang format: https://github.com/andersao/l5-repository#using-the-requestcriteria
 *
 * @package App\Criteria
 */
class  BuildDataSearchForRequest
{
    /**
     * @var string Giá trị tìm kiếm theo từ khoá
     */
    protected $search;


    /**
     * @var array danh sách các fields hỗ trợ filter chung theo keyword $search
     */
    protected $searchFieldsByKeyword = [];

    /**
     * @var array Chỉ định danh sách các field hỗ trợ filter
     */
    protected $searchFields = [];

    /**
     * @var array Danh sách các column cần trả về
     */
    protected $filter;
    /**
     * @var string Loại sắp xếp thư tự [desc, asc]
     */
    protected $sortedBy = 'desc';
    /**
     * @var string column chọn để sắp xếp theo $sortedBy
     */
    protected $orderBy;

    /**
     * @var array Mảng chứa danh sách các dữ liệu cần lấy theo relationship
     */
    protected $with;

    /**
     * @var
     */
    protected $withCount;

    /**
     * @var string
     */
    protected $searchJoin = 'and';

    /**
     * @var array Thiết lập các trường kèm điều kiện tìm kiếm.
     *
     * Nếu giá trị này được xác định thì sẽ bỏ qua thiết lập mặc định trong repositoryEloquent tương ứng
     *
     */
    protected $forceFieldsSearchable = [];


    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Chỉ định các fieldsSearchable được phép áp dụng hỗ trợ gán condition filter
     * @param array|null $searchFields
     * @return $this
     */
    public function setSearchFields(array $searchFields = null)
    {
        $this->searchFields = $searchFields;
        return $this;
    }


    /**
     * Mac dinh la []. Neu thiet lap thi het thong chi su dung gia tri vua thiet lap
     * @param array $forceFieldsSearchable
     * @return $this
     */
    public function setForceFieldsSearchable(array $forceFieldsSearchable = [])
    {
        if (count($forceFieldsSearchable)) {
            $this->forceFieldsSearchable = $forceFieldsSearchable;
        }
        return $this;
    }

    /**
     * Xac dinh cac truong can tim voi param query
     * @param string $keyword
     * @param array $fields_search
     * @return $this
     */
    public function setSearch($keyword = '', array $fields_search = [])
    {
        $search = '';
        foreach ($fields_search as $field_mapping => $field) {
            $value = $this->request->get($field);
            if (is_numeric($field_mapping) && trim($value) != '') {
                $search .= ";$field:" . $value;
            } elseif (trim($value) != '') {
                $search .= ";$field_mapping:" . $value;
            }
        }
        $search = trim($search, ';');
        $keyword = $this->request->get($keyword, null);
        $this->search = $search ? ($keyword ? $keyword . ';' . $search : $search) : $keyword;
        return $this;
    }

    /**
     * Danh sach cac column can lay (null => lay toan bo)
     * @param array|null $filter
     * @return $this
     */
    public function setFilter(array $filter = [])
    {
        $this->filter = count($filter) > 0 ? implode(';', $filter) : null;
        return $this;
    }

    /**
     * Cột cần order
     * Doc: https://github.com/andersao/l5-repository#create-a-criteria
     *
     * @param string|null $orderBy
     * @return $this
     */
    public function setOrderBy(string $orderBy = null)
    {
        $this->orderBy = $orderBy ?? $this->request->get('order_by');
        return $this;
    }

    /**
     * Kieu sắp xếp : desc | asc
     * Doc: https://github.com/andersao/l5-repository#create-a-criteria
     *
     * @param string $sortedBy
     * @return $this
     */
    public function setSortedBy($sortedBy = 'desc')
    {
        $this->sortedBy = $sortedBy ?? $this->request->get('order');
        return $this;
    }

    /**
     * @param null $withCount
     * @return $this
     */
    public function setWithCount($withCount = null)
    {
        $this->withCount = $withCount;
        return $this;
    }

    /**
     * @param $with
     * @return $this
     */
    public function setWith(array $with = [])
    {
        if (count($with))
            $this->with = implode(';', $with);
        return $this;
    }


    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function pushSearch($key, $value)
    {
        $this->search = $this->search ? $this->search . ";$key:$value" : "$key:$value";
        return $this;
    }

    public function setSearchJoin($searchJoin = 'and')
    {
        if (!in_array($searchJoin, ['and', 'or'])) {
            throw new \Exception('searchJoin support only in array [and,or]');
        }
        $this->searchJoin = $searchJoin;
        return $this;
    }

    /**
     * @param  array $searchFieldsByKeyword Danh sách các fields hỗ trợ filter chung theo keyword $search
     * @return $this
     */
    public function searchFieldsByKeyword(array $searchFieldsByKeyword = [])
    {
        $this->searchFieldsByKeyword = $searchFieldsByKeyword;
        return $this;
    }

    public function getDataSearch()
    {
        return [
            'forceFieldsSearchable' => $this->forceFieldsSearchable ?? [],
            'searchFieldsByKeyword' => $this->searchFieldsByKeyword,
            'search' => $this->search,
            'searchFields' => $this->searchFields,
            'filter' => $this->filter,
            'with' => $this->with,
            'withCount' => $this->withCount,
            'searchJoin' => $this->searchJoin,
            'orderBy' => $this->orderBy ? $this->orderBy : $this->request->get('order_by'),
            'sortedBy' => $this->sortedBy ? $this->sortedBy : $this->request->get('order')
        ];
    }
}
