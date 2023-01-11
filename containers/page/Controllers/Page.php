<?php

namespace Page\Controllers;

use JsonException;
use League\Flysystem\FilesystemException;
use Page\Fields\HeaderBlockField;
use SailCMS\Collection;
use SailCMS\Contracts\AppController;
use SailCMS\Errors\ACLException;
use SailCMS\Errors\DatabaseException;
use SailCMS\Errors\EntryException;
use SailCMS\Errors\PermissionException;
use SailCMS\Http\Response;
use SailCMS\Models\EntryLayout;
use SailCMS\Models\EntryType;
use SailCMS\Models\Entry;
use SailCMS\Models\User;
use SailCMS\Types\EntryStatus;
use SailCMS\Types\LocaleField;
use SodiumException;

class Page extends AppController
{
    /**
     * @throws DatabaseException
     * @throws EntryException
     * @throws JsonException
     * @throws FilesystemException
     * @throws ACLException
     * @throws PermissionException
     * @throws SodiumException
     *
     */
    public function create_data():void
    {
        $msgs = new Collection();

        if (!User::$currentUser) {
            (new User())->login("philippe@leeroy.ca", "Hell0W0rld!");
        }

        $entryTypeModel = new EntryType();

        $pageEntryType = $entryTypeModel->getByHandle('page');

        $pageModel = $pageEntryType->getEntryModel();

        $page = $pageModel->one(['slug' => 'home']);

        if (!$page) {
            $page = $pageModel->create(true, 'en', EntryStatus::LIVE->value, 'Home');

            $msgs->push('Page created');
        }

        if ($pageEntryType->entry_layout_id == "639359dc2ce8dcaf4a06e090") {
            $msgs->push('Layout exists');

            $entryLayoutModel = new EntryLayout();
            $entryLayout = $entryLayoutModel->one(['_id' => $pageEntryType->entry_layout_id]);

            if (!$entryLayout->schema->get('headerBlock')) {
                $headerBlock = new HeaderBlockField(new LocaleField((object)['en'=>'Header', 'fr'=>'Entête']), [
                    "blockTitle" => [
                        'maxLength' => 255
                    ],
                    "blockDescription" => [
                        'minLength' => 50
                    ]
                ]);

                $entryLayout->schema->pushKeyValue('headerBlock', $headerBlock);
                $newSchema = EntryLayout::generateLayoutSchema($entryLayout->schema);
                $entryLayout->updateById($pageEntryType->entry_layout_id, null, $newSchema);
                $msgs->push('Update Entry layout');
            }
        }

        if ($page) {
            $msgs->push('Page exists');

            if (!$page->content->get('headerBlock')) {
                $pageModel->updateById($page->_id, ['content' => [
                    'headerBlock' => [
                        'blockTitle' => 'This is the home page',
                        'blockDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Praesent gravida metus in ipsum rhoncus congue. Curabitur luctus velit mauris, ut sagittis tellus pharetra at. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nec lacinia tellus, commodo elementum erat. 
Integer dictum diam viverra sodales eleifend. In sit amet vestibulum augue. In feugiat eu tortor sed varius. Suspendisse quis suscipit eros. Aenean elit odio, semper in suscipit et, elementum ut diam. Morbi sed auctor nulla, id sollicitudin odio. '
                    ]
                ]]);

                $msgs->push('Update page content #' . $page->_id);
            }
        }

        $this->response->set('msgs', $msgs);
        $this->response->template = 'default/page';
    }

    public function __toString(): string
    {
        return "Page controller";
    }
}