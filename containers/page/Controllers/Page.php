<?php

namespace Page\Controllers;

use SailCMS\Collection;
use SailCMS\Contracts\AppController;
use SailCMS\Errors\DatabaseException;
use SailCMS\Errors\EntryException;
use SailCMS\Http\Response;
use SailCMS\Models\EntryType;
use SailCMS\Models\Entry;
use SailCMS\Types\EntryStatus;

class Page extends AppController
{
    /**
     * @throws DatabaseException
     */
    public function home():void
    {
        $error = '';
        $pageEntryQs = new EntryType();

        // It's only for test purpose we can use getByHandle when it's created instead
        try
        {
            $pageEntryType = $pageEntryQs->getOrCreateByHandle(new Collection([
                'handle' => 'page',
                'title' => 'Page',
                'urlPrefix' => ''
            ]));
        }
        catch (DatabaseException|EntryException $exception)
        {
            $error = 'There was an error when creating the entry type:' . PHP_EOL . $exception->getMessage() . PHP_EOL;
        }

        if (isset($pageEntryType)) {
            $pageQs = new Entry($pageEntryType);

            // It's only for test purpose, when it's created we can use the getBySlug method
            $pageEntry = $pageQs->getOrCreate(new Collection([
                'title' => 'Home page',
                'slug' => '',
                'status' => EntryStatus::LIVE
            ]));
            $this->response->set('title', $pageEntry->title);
        }

        $this->response->set('error', $error);
        $this->response->template = 'default/page';
    }
}