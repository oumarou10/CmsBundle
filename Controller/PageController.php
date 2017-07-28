<?php
/**
 * Created by PhpStorm.
 * User: oumarucho
 * Date: 23/07/2017
 * Time: 19:50
 */

namespace OC\CmsBundle\Controller;


use OC\CmsBundle\Entity\Page;
use OC\CmsBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class PageController extends Controller
{
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository(Page::class);

        $pages = $repository->findAll();

        return $this->render('OCCmsBundle:Cms:index.html.twig', compact('pages'));
    }

    public function createAction(Request $request)
    {
        $session = new Session();

        $page = new Page();

        $form = $this->createForm(PageType::class,$page);
        $form->add('create',SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $session->getFlashBag()->add('add_success', 'Votre page a bien été enregistré');

            return $this->redirectToRoute('oc_cms_pages');
        }

        return $this->render('OCCmsBundle:Cms:add.html.twig', ['form' => $form->createView()]);
    }


    public function pagesAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Page::class);
        $pages = $repository->findAll();

        return $this->render('OCCmsBundle:Cms:pages.html.twig', ['pages' => $pages ]);
    }


    public function readAction(Request $request, Page $page)
    {

        return $this->render('OCCmsBundle:Cms:onepage.html.twig', ['page' => $page]);
    }

    public function updateAction(Request $request, Page $page)
    {
        $session = new Session();

        $form = $this->createForm(PageType::class,$page);
        $form->add('edit',SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() & $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $session->getFlashBag()->add('update_success', 'Votre page a bien été modifiée');

            return $this->redirectToRoute('oc_cms_pages');
        }

        return $this->render('OCCmsBundle:Cms:editpage.html.twig', ['form' => $form->createView(), 'page' => $page]);
    }

    public function deleteAction(Request $request, Page $page)
    {
        $session = new Session();

        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        $session->getFlashBag()->add('delete_success', 'Votre page a bien été supprimée');

        return $this->redirectToRoute('oc_cms_pages');

    }

}