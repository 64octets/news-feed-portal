<?php

namespace Controller;

class Feed extends Base
{
    public function index()
    {
        $self = $this;
        $data = $self->request()->params();

        $this->run(function () use ($self, $data) {
            return $self->action("Service\Feed\Index")->run($data);
        });
    }

    public function pubDates()
    {
        $self = $this;
        $data = $self->request()->params();

        $this->run(function () use ($self, $data) {
            return $self->action("Service\Feed\PubDates")->run($data);
        });
    }

    public function show($id)
    {
        $self = $this;
        $data = ['Id' => $id];

        $this->run(function () use ($self, $data) {
            return $self->action("Service\Feed\Show")->run($data);
        });
    }

    public function create()
    {
        $self = $this;
        $data = $self->request()->params();

        $this->run(function () use ($self, $data) {
            return $self->action("Service\Users\Create")->run($data);
        });
    }

    public function update($id)
    {
        $self = $this;

        $data = $self->request()->params();
        $data['Id'] = $id;

        $this->run(function () use ($self, $data) {
            return $self->action("Service\Feed\Update")->run($data);
        });
    }

    public function delete($id)
    {
        $self = $this;
        $data = ['Id' => $id];

        $this->run(function () use ($self, $data) {
            return $self->action("Service\Feed\Delete")->run($data);
        });
    }
}
