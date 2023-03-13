<?php

namespace Page\Middleware;

use SailCMS\Contracts\AppMiddleware;
use SailCMS\Middleware\Data;
use SailCMS\Middleware\Entry;
use SailCMS\Types\MiddlewareType;

class TestMiddleware implements AppMiddleware
{

    public function type(): MiddlewareType
    {
        return MiddlewareType::ENTRY;
    }

    public function process(Data $data): Data
    {
        switch ($data->event)
        {
            case Entry::BeforeCreate:
                if ($data->data['title']) {
                    $data->data['title'] .= '-middleware-create';
                }
                break;

            case Entry::BeforeUpdate:
                if ($data->data['title']) {
                    $data->data['title'] .= '-middleware-update';
                }
                break;

            default:
                break;
        }

        return $data;
    }
}