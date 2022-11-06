<?php

/**
 * This class for create format pagination data
 * Used by ApiController.
 *
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PagingData
{
    private $request;
    private $validated;
    private $data;
    private $size;
    private $page;
    private $totalData;
    private $totalFiltered;
    private $searchableColumns;
    private $orderableColumns;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setValidated(array $validated)
    {
        $this->validated = $validated;
    }

    public function getValidated()
    {
        return $this->validated;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setSize(int $size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getTotalPage()
    {
        return ceil($this->totalData / $this->size);
    }

    public function setTotalData(int $totalData)
    {
        $this->totalData = $totalData;
    }

    public function getTotalData()
    {
        return $this->totalData;
    }

    public function setTotalFiltered(int $totalFiltered)
    {
        $this->totalFiltered = $totalFiltered;
    }

    public function getTotalFiltered()
    {
        return $this->totalFiltered;
    }

    public function setSearchableColumns(array $searchableColumns)
    {
        $this->searchableColumns = $searchableColumns;
    }

    public function getSearchableColumns()
    {
        return $this->searchableColumns;
    }

    public function setOrderableColumns(array $orderableColumns)
    {
        $this->orderableColumns = $orderableColumns;
    }

    public function getOrderablecolumns()
    {
        return $this->orderableColumns;
    }

    public function validateRequest()
    {
        $orderableColumns = $this->getOrderablecolumns();
        $request = $this->getRequest();
        $rules = [
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
            'search' => 'nullable|string',
            // 'sort.name' => [
            //     'nullable',
            //     Rule::in($orderableColumns),
            // ],
            // 'sort.dir' => [
            //     'required_with:sort.name',
            //     Rule::in(['asc', 'desc', 'random']),
            // ],
            'sortBy' => [
                'nullable',
                Rule::in($orderableColumns)
            ],
            'sortDir' => [
                'required_with:sortBy',
                Rule::in(['asc', 'desc', 'random']),
            ]
        ];

        // for custom messages
        $messages = [
            'sortBy.in' => 'Only Allowed: ' . implode(', ', $orderableColumns),
            'sortDir.in' => 'Only allowed \'asc\', \'desc\' and \'random\'',
        ];

        $validated = Validator::make($request->all(), $rules, $messages)->validate();
        $this->setValidated($validated);
    }

    public function paginateData(QueryBuilder $query, $where = [])
    {
        $this->validateRequest();
        $validated = $this->getValidated();
        $searchableColumns = $this->getSearchableColumns();
        $totalData = $query->where($where)->get()->count();
        $this->setTotalData($totalData);

        $search = !empty($validated['search']) ? $validated['search'] : null;
        if (!empty($search)) {
            $query->where(function ($q) use ($searchableColumns, $search) {
                $i = 0;
                $search = strtolower($search);
                foreach ($searchableColumns as $searchableColumn) {
                    if (0 == $i) {
                        // $q->where($searchableColumn, 'ilike', '%' . $search . '%');
                        $q->whereRaw("lower({$searchableColumn}) like (?)", ["%{$search}%"]);
                    } else {
                        // $q->orWhere($searchableColumn, 'ilike', '%' . $search . '%');
                        $q->orWhereRaw("lower({$searchableColumn}) like (?)", ["%{$search}%"]);
                    }
                    ++$i;
                }
            });
        }
        $totalFiltered = $query->count();
        $this->setTotalFiltered($totalFiltered);

        // ordering data
        $sortBy = !empty($validated['sortBy']) ? $validated['sortBy'] : null;
        if (!empty($sortBy)) {
            $sortDir = !empty($validated['sortDir']) ? $validated['sortDir'] : 'asc';
            if ('random' == $sortDir) {
                $query->inRandomOrder();
            } else {
                $query = $query->orderBy($sortBy, $sortDir);
            }
        }

        // paginate data
        $page = !empty($validated['page']) ? $validated['page'] : 1;
        $size = !empty($validated['size']) ? $validated['size'] : 100;
        if (!empty($page)) {
            $offset = ($page - 1) * $size;
            $query = $query->offset($offset)
                ->limit($size);
        }

        $this->setPage($page);
        $this->setSize($size);

        $data = $query->get();
        $this->setData($data->toArray());
    }
}
