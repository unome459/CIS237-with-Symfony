<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProduceItem;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ItemController extends BaseController {

    /**
     * @Route("/new-item-fridge", name="item_fridge")
     */
    public function new(Request $request) {
        $item = new ProduceItem("Enter a new Produce Item name", new \DateTime('today'), "", "");

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
     * @Route("/fridge-list-item", name="item_list_fridge", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function list(Request $request) {
        $repository = $this->getDoctrine()->getRepository(ProduceItem::class);

        $items = $repository->findAll();

        return $this->render('item-list.html.twig', ['items' => $items]);
    }

    /**
     * @Route("/item/delete/{id}", name="delete_item", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteItem(int $id) {
        $repo = $this->getDoctrine()->getRepository(ProduceItem::class);
        $item = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
    /**
     * @Route("produce_item/{id}/edit", name="edit_produce_item", requirements={"id"="\d+"})
     */
    public function editItem(it $id, Request $request) {
        $repo = $this->getDoctrine()->getRepository(ProduceItem::class);
        $item = $repo->find($id);

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            return new Response('Item ' . $item->getId() . ' got updated!');
        }
        return $this->render('new-item.html.twig', ['form' => $form->createView(), 'label' => 'Edit Item']);
    }
    /**
     * @Route("produce_item/{id}", name="ajax_edit_produce_item", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function ajaxEditProduceItem(int $id, Request $request) {
        $item = $this->getDoctrine()->getRepository(ProduceItem::class)->find($id);

        //TODO extract data from Request

        $data = $request->request->all();

        //Save that data to a Item

        $form = $this->createForm(ItemType::class, $item);
        $form->submit($data);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($item);
        $entityManager->flush();

        return JsonReponse([], Response::HTTP_OK);
    }
    /**
     * @Route("produce_item/download", name="produce_item_download")
     */
    public function download() {
        $repository = $this->getDoctrine()->getRepository(ProduceItem::class);
        $items = $repository->findAll();
        $fileName = 'item_list.txt';

        $fp = fopen($fileName, 'w');

        $content = '';

        foreach($items as $item) {
            $n = $item->getName();
            $ed = $item->getExpirtionDate();
            $i = $item->getImage();
            $content .= "$n $ed $i:\n";

            fwrite($fp, $content);
            fclose($fp);

            return $this->file($fileName);
        }
    }
}