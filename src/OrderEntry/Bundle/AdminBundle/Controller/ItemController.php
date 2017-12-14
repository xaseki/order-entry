<?php

namespace OrderEntry\Bundle\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use OrderEntry\Bundle\AppBundle\Entity\Item;
use OrderEntry\Bundle\AppBundle\Repository\ItemRepository;
use OrderEntry\Bundle\AdminBundle\Form\Type\ItemFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrderEntry\Bundle\AppBundle\Entity\ItemCategory;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class Item
 * @package OrderEntry\Bundle\AdminBundle\Controller
 * @Route("/item")
 */
class ItemController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /** @var ItemRepository $repository */
        $repository = $this->getItemRepository();

        $qb = $repository->createQueryBuilder('i')
            ->orderBy('i.created', 'DESC')
        ;


        $keyword = $request->get('q', '');
        if ($keyword) {
            $qb->leftJoin('i.category', 'c')
                ->where($qb->expr()->orX(
                    $qb->expr()->like('i.name', ':keyword'),
                    $qb->expr()->like('i.price', ':keyword'),
                    $qb->expr()->like('c.name', ':keyword')
                ))->setParameter('keyword', '%' . $keyword .  '%');
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1)/*page number*/,
            30/*limit per page*/
        );

        $form = $this->createDeleteForm();
//        echo '<pre>';
//        var_dump($form);
//        echo '</pre>';

        return [
            'pagination' => $pagination,
            'keyword' => $keyword,
            'form' => $form->createview()
        ];
    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function createAction(Request $request)
    {
        /** @var Item $item */
        $item = new Item();

        $form = $this->createForm(ItemFormType::class, $item);
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
     * @param Item $item
     * @param Request $request
     * @Template()
     */
    public function editAction(Item $item, Request $request)
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
        $form = $this->createDeleteForm();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($item);
                $em->flush();
                $this->addFlash('', 'アイテムを削除しました');

        }

        return $this->redirectToRoute('orderentry_admin_item_index');
    }


    public function createDeleteForm()
    {
        return $this->get('form.factory')->createNamed('admin_item');
    }

    /**
     * @return ItemRepository
     */
    public function getItemRepository()
    {
        return $this->getDoctrine()->getRepository(Item::class);
    }
}
