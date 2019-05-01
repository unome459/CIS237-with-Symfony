<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProduceItem;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends BaseController {

    /**
     * @Route("/new-task", name="task")
     */
    public function new(Request $request) {
        $task = new ProduceItem("Enter a new Produce Item name", new \DateTime('today'), "");

        $form = $this->createForm(TaskType::class, $task);

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
            $entityManager->persist($task);
            $entityManager->flush();

            return new Response('New item got added to the database ' . $task->getId());
        }

        return $this->render('new-task.html.twig', ['task_form' => $form->createView()]);

    }

    /**
     * @Route("/list-task", name="task_list")
     */
    public function list() {
        $repository = $this->getDoctrine()->getRepository(ProduceItem::class);

        $items = $repository->findAll();

        return $this->render('task-list.html.twig', ['items' => $items]);
    }

}
