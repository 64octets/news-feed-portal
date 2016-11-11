<?php

namespace Service\Feed;

class PubDates extends \Service\Base
{
    public function validate()
    {
        //
    }

    public function execute()
    {
        $dates = \Engine\FeedsQuery::create()
            ->select(['PubDate'])
            ->orderBy('PubDate', 'desc')
            ->find()
            ->toArray();

        $dates = array_unique($dates);

        return [
            'Status'    => 1,
            'Total'     => count($dates),
            'Dates'     => $dates,
        ];
    }
}
