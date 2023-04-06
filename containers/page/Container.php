<?php

namespace Page;


use JetBrains\PhpStorm\Pure;
use Page\Controllers\Page;
use Page\Fields\HeaderBlockField;
use Page\Middleware\TestMiddleware;
use SailCMS\Debug;
use SailCMS\Event;
use SailCMS\Middleware;
use SailCMS\Models\Entry;
use SailCMS\Types\ContainerInformation;
use SailCMS\Contracts\AppContainer;
use SailCMS\Collection;

class Container extends AppContainer
{
    #[Pure]
    public function info(): ContainerInformation
    {
        return new ContainerInformation(name: 'Page', description: 'All pages', version: 1.0, semver: '1.0.0');
    }

    public function routes(): void
    {
        $this->router->get('/create-data', 'en', Page::class, 'create_data', 'pages');
    }

    public function configureSearch(): void
    {

    }

    public function cli(): Collection
    {
        return new Collection([]);
    }

    public function graphql(): void
    {
        // TODO: Implement graphql() method.
    }

    public function middleware(): void
    {
//        Middleware::register(new TestMiddleware());
    }

    public function permissions(): Collection
    {
        return Collection::init();
    }

    public function events(): void
    {
        // TODO: Implement events() method.
//        Event::register(Entry::EVENT_CREATE, self::class, 'entryPostCreate');
//        Event::register(Entry::EVENT_UPDATE, self::class, 'entryPostUpdate');
//        Event::register(Entry::EVENT_DELETE, self::class, 'entryPostDelete');
    }

    public function fields(): Collection
    {
        return new Collection([
            HeaderBlockField::info()
        ]);
    }

    /** EVENTS TESTS */
    public function entryPostCreate($event, $data) {
        /**
         * @var Entry $entry;
         */
        $entry = $data['entry'];
        print_r($entry->url);
    }

    public function entryPostUpdate($event, $data) {
        if ($data['entry']->title === $data['update']['title']) {
           print_r('allllllllo');
        }
    }

    public function entryPostDelete($event, $data) {
        print_r($data['entryId']);
    }
}