<?php
/**
 * Created by PhpStorm.
 * User: oumarucho
 * Date: 23/07/2017
 * Time: 19:50
 */

namespace OC\CmsBundle\Controller;

use OC\CmsBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCCmsBundle:Cms:index.html.twig');
    }

    /**
     * @Route("/page/create", name="add")
     */
    public function createAction(Request $request)
    {
        $page = new Page();

        $form = $this->createFormBuilder()
            ->add('title',TextType::class)
            ->add('content',TextType::class)
            ->add('submit',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $data = $form->getData();

            $page->setTitle($data['title']);
            $page->setContent($data['content']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            //$em->flush();

            return $this->redirectToRoute('allPages');
        }

        return $this->render('OCCmsBundle:Cms:add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/pages", name="allPages")
     */
    public function pagesAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Page::class);
        $pages = $repository->findAll();

        return $this->render('OCCmsBundle:Cms:pages.html.twig', ['pages' => $pages ]);
    }
}