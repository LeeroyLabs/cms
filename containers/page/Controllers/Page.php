<?php

namespace Page\Controllers;

use SailCMS\Collection;
use SailCMS\Contracts\AppController;
use SailCMS\Http\Response;
use SailCMS\Models\EntryType;
use SailCMS\Models\Entry;

class Page extends AppController
{
    public function home():void
    {
        $pageEntryQs = new EntryType();
        $pageEntry = $pageEntryQs->getOrCreateByHandle(new Collection([
            'handle' => 'page',
            'title' => 'Page',
            'urlPrefix' => ''
        ]));
//        $pageQs = new Entry();
//        $this->response->template = 'default/page';
    }
}