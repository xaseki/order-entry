<?php

namespace OrderEntry\Bundle\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use OrderEntry\Bundle\AppBundle\Entity\Store;
use OrderEntry\Bundle\AppBundle\Repository\ItemRepository;
use OrderEntry\Bundle\AppBundle\Repository\StoreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrderEntry\Bundle\AppBundle\Entity\ItemCategory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class Store
 * @package OrderEntry\Bundle\AdminBundle\Controller
 * @Route("/store")
 */
class StoreController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $qb = $this->getStoreRepository()->createQueryBuilder('s')
            ->orderBy('id', 'desc');


        $store = $qb->getQuery()->getResult();



        return [
            'store' => $store
        ];
    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createItemAction(Request $request)
    {
        /** @var ItemCategory $item */
        $store = new Store();

        $form = $this->createForm(ItemFormType::class, $store);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($item);
                $em->flush();
                $this->addFlash('success', 'アイテムを作成しました。');
                return $this->redirectToRoute('orderentry_admin_item_index');

            }
        }
        return [
            'item' => $item,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}/edit")
     * @param ItemCategory $item
     * @param Request $request
     */
    public function editAction(ItemCategory $item, Request $request)
    {
        $form = $this->createForm(ItemFormType::class, $item);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($item);
                $em->flush();

                $this->addFlash('success', 'アイテムを編集しました。');
                return $this->redirectToRoute('orderentry_admin_item_edit', ['id' => $item->getId()]);
            }
        }
        return [
            'form' => $form,
            'item' => $item
        ];
    }

    /**
     * @Route("/{id}/delete")
     * @param Request $request
     * @param $id
     */
    public function deleteAction(Request $request, $id)
    {
        $response = [
            'success' => true,
            'message' => '',
            'html' => '',
        ];

        /** @var ItemCategory $item */
        $item = $this->getItemRepository()->find($id);
        $form = $this->createDeleteForm($item);
        if ($request->isMethod('DELETE')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($item);
                $em->flush();


            } else {
                $request['success'] = false;
                $request['message'] = 'アイテムの削除に失敗しました。';
            }
        }
    }

    /**
     * @param ItemCategory $item
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm(ItemCategory $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderentry_admin_item_delete', ['id' => $item->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @return StoreRepository
     */
    public function getStoreRepository()
    {
        return $this->getDoctrine()->getRepository(Store::class);
    }
}
