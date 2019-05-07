<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProduceItem;
use App\Form\ItemType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends BaseController {

    /**
     * @Route("/new-item", name="item")
     */
    public function new(Request $request) {
        $item = new ProduceItem("Enter a new Produce Item name", new \DateTime('today'), "");

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
     * @Route("/list-item", name="item_list")
     */
    public function list() {
        $repository = $this->getDoctrine()->getRepository(ProduceItem::class);

        $items = $repository->findAll();

        return $this->render('item-list.html.twig', ['items' => $items]);
    }

}
