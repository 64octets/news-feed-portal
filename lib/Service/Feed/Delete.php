<?php

namespace Service\Feed;

class Delete extends \Service\Base
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

        $feed->delete();

        return [
            'Status'    => 1,
        ];
    }
}
