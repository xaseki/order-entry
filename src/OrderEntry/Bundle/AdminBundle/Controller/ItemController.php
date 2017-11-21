<?php

namespace OrderEntry\Bundle\AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use OrderEntry\Bundle\AppBundle\Repository\ItemRepository;
use OrderEntry\Bundle\UserBundle\Form\ItemFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrderEntry\Bundle\AppBundle\Entity\Item;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $qb = $this->getItemRepository()->createQueryBuilder('i')
            ->orderBy('id', 'desc');

        $keyword = $request->get('q', '');
        if ($keyword) {
            $qb->leftJoin('i.category', 'c')
                ->where($qb->expr()->orX(
                    $qb->expr()->like('i.name', ':keyword'),
                    $qb->expr()->like('i.price', ':keyword'),
                    $qb->expr()->like('c.name', ':keyword')
                ))->setParameter('keyword', '%' . $keyword .  '%');
        }

        $item = $qb->getQuery()->getResult();



        return [
            'item' => $item,
            'keyword' => $keyword,
        ];
    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createItemAction(Request $request)
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

        /** @var Item $item */
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
     * @param Item $item
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm(Item $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderentry_admin_item_delete', ['id' => $item->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @return ItemRepository
     */
    public function getItemRepository()
    {
        return $this->getDoctrine()->getRepository(Item::class);
    }
}
