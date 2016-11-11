<?php

namespace Service\Feed;

class Index extends \Service\Base
{
    public function validate($params)
    {
        $rules = [
            'Search'    => ['max_length' => 100],

            'Limit'     => ['integer', ['min_number' => 0]],
            'Offset'    => ['integer', ['min_number' => 0]],

            'SortField' => ['one_of' => ['Id', 'Title']],
            'SortOrder' => ['one_of' => ['asc', 'desc']],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params = $this->defaultParams($params, 'Id');

        $query = \Engine\FeedsQuery::create()
            ->filterByPubDate($params['Search'])
            ->orderBy($params['SortField'], $params['SortOrder']);

        $totalCount = \Engine\FeedsQuery::create()->count();
        $filteredCount = $query->count();

        $feeds = $query
            ->limit($params['Limit'])
            ->offset($params['Offset'])
            ->find();

        return [
            'Status'        => 1,
            'Total'         => $totalCount,
            'FilteredCount' => $filteredCount,
            'Feeds'         => $feeds->toArray(),
        ];
    }
}
