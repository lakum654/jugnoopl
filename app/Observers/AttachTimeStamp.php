<?php

namespace App\Observers;

class AttachTimeStamp
{
    public function saving($model)

    {
        if (empty($model->_id))
            $model->created = time();

        $model->updated = time();
    }

    public function updating($model)
    {
        $model->updated = time();
    }

    public function deleted($model)
    {

        $model->deleted = time();
    }
}
