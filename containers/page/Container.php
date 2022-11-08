<?php

namespace Page;


use JetBrains\PhpStorm\Pure;
use Page\Controllers\Page;
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
        $this->router->get('/page', 'fr', Page::class, 'home', 'pages');
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
        // TODO: Implement middleware() method.
    }

    public function permissions(): Collection
    {
        return new Collection([]);
    }

    public function events(): void
    {
        // TODO: Implement events() method.
    }
}