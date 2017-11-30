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
}