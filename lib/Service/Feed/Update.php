<?php

namespace Service\Feed;

class Update extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'            => ['required', 'positive_integer'],
            'Title'         => ['required', ['max_length' => 255]],
            'Description'   => ['max_length' => 1024],
            'Author'        => ['max_length' => 255],
            'PubDate'       => ['required', 'iso_date'],
            'PubTime'       => ['required'],
            'Thumbnail'     => ['required', 'url', ['max_length' => 255]],
            'Source'        => ['required', 'url', ['max_length' => 255]],
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

        $feed->fromArray($params);
        $feed->save();

        return [
            'Status'    => 1,
        ];
    }
}
