<?php
namespace App\Overrides;
class RemoteManager extends \Collective\Remote\RemoteManager
{
    protected function getConfig($model)
    {
        return $model->getConfig();
    }
}