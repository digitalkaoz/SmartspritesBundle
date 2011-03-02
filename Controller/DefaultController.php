<?php

namespace rs\SmartspritesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SmartspritesBundle:Default:index.html.twig');
    }
}
