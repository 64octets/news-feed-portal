<?php

namespace Service\Feed;

class Create extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
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
        $feed = new \Engine\Feeds();
        $feed->fromArray($params);
        $feed->save();

        return [
            'Status' => 1,
            'FeedId' => $feed->getId(),
        ];
    }
}
