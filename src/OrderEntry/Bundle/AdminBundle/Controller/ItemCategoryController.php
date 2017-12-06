<?php

namespace OrderEntry\Bundle\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use OrderEntry\Bundle\AdminBundle\Form\Type\ItemCategoryFormType;
use OrderEntry\Bundle\AppBundle\Entity\ItemCategory;
use OrderEntry\Bundle\AppBundle\Repository\ItemCategoryRepository;
use OrderEntry\Bundle\AdminBundle\Form\Type\ItemFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class Item
 * @package OrderEntry\Bundle\AdminBundle\Controller
 * @Route("/item/category")
 */
class ItemCategoryController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $qb = $this->getItemCategoryRepository()->createQueryBuilder('ic');

        /** @var Paginator $paginator */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            20
        );

        return [
            'pagination' => $pagination
        ];

    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function createItemAction(Request $request)
    {
        /** @var ItemCategory $item */
        $itemCategory = new ItemCategory();

        $form = $this->createForm(ItemCategoryFormType::class, $itemCategory);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($itemCategory);
                $em->flush();
                $this->addFlash('success', 'アイテムカテゴリーを作成しました。');
                return $this->redirectToRoute('orderentry_admin_itemcategory_index');

            }
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}/edit")
     * @param ItemCategory $itemCategory
     * @param Request $request
     * @Template()
     */
    public function editAction(ItemCategory $itemCategory, Request $request)
    {
        $form = $this->createForm(ItemFormType::class, $itemCategory);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($itemCategory);
                $em->flush();

                $this->addFlash('success', 'アイテムを編集しました。');
                return $this->redirectToRoute('orderentry_admin_item_edit', ['id' => $itemCategory->getId()]);
            }
        }
        return [
            'form' => $form->createView(),
            'item' => $itemCategory,
        ];
    }

    /**
     * @Route("/{id}/delete")
     * @param Request $request
     * @param $id
     * @Method("POST")
     */
    public function deleteAction(ItemCategory $itemCategory ,Request $request)
    {
        $form = $this->createDeleteForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($itemCategory);
            $em->flush();
            $this->addFlash('success', 'カテゴリーを削除しました。');

        }
        return $this->redirectToRoute('orderentry_admin_itemcategory_index');
    }


    public function createDeleteForm()
    {
        return $this->get('form.factory')->createNamed('admin_item_delete');
    }

    /**
     * @return ItemCategoryRepository
     */
    public function getItemCategoryRepository()
    {
        return $this->getDoctrine()->getRepository(ItemCategory::class);
    }
}
