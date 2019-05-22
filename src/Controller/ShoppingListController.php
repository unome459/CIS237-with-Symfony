<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProduceItem;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShoppingListController extends BaseController {

    /**
     * @Route("/new-item-shopping", name="item_shopping")
     */
    public function new(Request $request) {
        $item = new ProduceItem("Enter a new Produce Item name", "", "", "");

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        /**  if($form->isSubmitted()) {
        $imageFile = $task->getImage();

        $fileName = md5(uniqid()) . '.' . $imageFile->guessExtension();

        $rootDirPath = $this->get('kernel')->getRootDir() . '/../public/uploads';

        $imageFile->move($rootDirPath, $fileName);

        $task->setImage($fileName);

        $task = $form->getData();
        return new Response(
        '<html><body>New item was added: ' . $task->getName() . ' expires on ' . $task->getExpirationDate()->format('Y-m-d') .
        ' Hashed file name: ' . $task->getImage() . '<img src="/uploads/' . $task->getImage() . '"/></body></html>'
        );
        } **/

        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            return new Response('New item got added to the database ' . $item->getId());
        }

        return $this->render('new-item.html.twig', ['item_form' => $form->createView()]);

    }

    /**
     * @Route("/shopping-list-item", name="item_list_shopping")
     */
    public function list(Request $request) {
        $repository = $this->getDoctrine()->getRepository(ProduceItem::class);

        $items = $repository->getRefrigeratorItems();

        return $this->render('item-list.html.twig', ['items' => $items]);
    }

}