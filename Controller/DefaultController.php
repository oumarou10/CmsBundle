<?php

namespace OC\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCCmsBundle:Default:index.html.twig');
    }

    public function addAction()
    {
        return new Response('Page add action');
    }
}
