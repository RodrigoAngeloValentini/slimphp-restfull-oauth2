<?php

namespace WebDevBr;

class Tasks
{
    private $qb;

    public function __construct($qb)
    {
        $this->qb = $qb;
    }

    public function fetch($id)
    {
        $result = $this->qb->select('*')
            ->from('tasks')
            ->where('id='.$id)
            ->execute()
            ->fetch();

        return $result;
    }

    public function validate($data)
    {
        if (!isset($data['title'])) {
            throw new \Exception("Title is required");
        }

        if (!isset($data['description'])) {
            throw new \Exception("Description is required");
        }

        if (!isset($data['datetime'])) {
            throw new \Exception("Datetime is required");
        }
    }
}