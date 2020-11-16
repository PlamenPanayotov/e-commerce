<?php
namespace App\Controller\Admin;

use App\Entity\Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/attachments")
 */
class AdminAttachmentController extends AbstractController
{
    /**
     * @Route("/{id}/delete", name="attachment_delete", methods={"GET", "DELETE"})
     */
    public function delete(Request $request, Attachment $attachment): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attachment);
            $entityManager->flush();
        
        $url = $_SERVER['HTTP_REFERER'];
        return $this->redirect($url);
    }
}