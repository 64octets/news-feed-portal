<?php

namespace Service\Feed;

class Show extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $feed = \Engine\FeedsQuery::create()->findOneById($params['Id']);

        if (!$feed) {
            throw new \Service\X([
                'Type'    => 'WRONG_ID',
                'Fields'  => ['Id' => 'WRONG_ID'],
                'Message' => 'Cannot find feed with id = ' . $params['Id'],
            ]);
        }

        return [
            'Status'    => 1,
            'Feed'      => $feed->toArray(),
        ];
    }
}
