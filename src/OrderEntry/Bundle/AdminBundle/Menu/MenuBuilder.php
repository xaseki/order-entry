<?php
namespace OrderEntry\Bundle\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class MenuBuilder
 * @package OrderEntry\Bundle\AdminBundle\Menu
 * @DI\Service()
 * @DI\Tag(name="knp_menu.menu_builder", attributes={"method"="createMainMenu", "alias"="admin_main"})
 *
 */
class MenuBuilder
{

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * MenuBuilder constructor.
     * @param FactoryInterface $factory
     * @DI\InjectParams({
     *     "factory"=@DI\Inject("knp_menu.factory")
     * })
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root',[
            'childrenAttributes' => ['class' => 'list'],
        ]);

        $this->buildMain($menu);
        $this->buildContents($menu);
        $this->buildMaster(($menu));


        return $menu;
    }

    public function buildMain(ItemInterface $menu)
    {
        $menu->addChild('Main', [
            'attributes' => ['class' => 'header'],
        ]);

        $menu
            ->addChild('Home', array('route' => 'orderentry_web_default_index'))
            ->setExtra('icon', 'home')
        ;
        $itemMenu = $menu->addChild('店舗管理', [
            'uri' => 'javascript:void(0)',
            'childrenAttributes' => ['class' => 'ml-menu'],
            'linkAttributes' => ['class' => 'menu-toggle']
        ])
            ->setExtra('icon', 'local_drink')
        ;
        $itemMenu
            ->addChild('店舗一覧', [
                'uri' => 'javascript:void(0)',
                'childrenAttributes' => ['class' => 'ml-menu'],
                'linkAttributes' => ['class' => 'menu-toggle'],
            ])
        ;
    }

    private function buildContents(ItemInterface $menu)
    {


        $menu->addChild('アイテム管理', [
            'attributes' => ['class' => 'header'],
        ])
            ->setExtra('icon', 'local_drink')
        ;

        $pageMenu = $menu
            ->addChild('アイテム管理', [
                'uri' => 'javascript:void(0)',
                'childrenAttributes' => ['class' => 'ml-menu'],
                'linkAttributes' => ['class' => 'menu-toggle']
            ])
            ->setExtra('icon', 'description')
            ->setExtra('currentRoutes', ['orderentry_admin_item_edit'])
        ;
        $pageMenu->addChild('アイテム一覧', ['route' => 'orderentry_admin_item_index']);
        $pageMenu->addChild('アイテム新規作成', ['route' => 'orderentry_admin_item_create']);

    }
    private function buildMaster(ItemInterface $menu)
    {

        $menu->addChild('カテゴリー管理', [
            'attributes' => ['class' => 'header'],
        ]);

        $categoryMenu = $menu
            ->addChild('カテゴリー管理', [
                'uri' => 'javascript:void(0)',
                'childrenAttributes' => ['class' => 'ml-menu'],
                'linkAttributes' => ['class' => 'menu-toggle']
            ])
            ->setExtra('icon', 'storage')
            ->setExtra('currentRoutes', ['orderentry_admin_itemcategory_edit'])
        ;
        $categoryMenu->addChild('カテゴリー一覧', ['route' => 'orderentry_admin_itemcategory_index']);
        $categoryMenu->addChild('カテゴリー新規作成', ['route' => 'orderentry_admin_itemcategory_createitem']);

    }
}