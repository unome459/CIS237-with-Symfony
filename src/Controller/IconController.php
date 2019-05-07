<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Icon;
use App\Form\IconType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IconController extends BaseController
{

    /**
     * @Route("/new-icon", name="icon")
     */
    public function new(Request $request)
    {
        $icon = new Icon("Enter a new Icon name", "");

        $form = $this->createForm(IconType::class, $icon);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $imageFile = $icon->getImage();

            $fileName = md5(uniqid()) . '.' . $imageFile->guessExtension();

            $rootDirPath = $this->get('kernel')->getRootDir() . '/../public/uploads';

            $imageFile->move($rootDirPath, $fileName);

            $icon->setImage($fileName);

            $task = $form->getData();
            return new Response(
                '<html><body>New icon was added: ' . $task->getName() . '\n' .
                ' Hashed file name: ' . $task->getImage() . '<img src="/uploads/' . $task->getImage() . '"/></body></html>'
            );
        }
        /**
        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($icon);
            $entityManager->flush();

            return new Response('New icon got added to the database ' . $icon->getId());
        }
        **/

        return $this->render('new-icon.html.twig', ['icon_form' => $form->createView()]);

    }

    /**
     * @Route("/list-item", name="item_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Icon::class);

        $icons = $repository->findAll();

        return $this->render('icon-list.html.twig', ['icons' => $icons]);
    }

}