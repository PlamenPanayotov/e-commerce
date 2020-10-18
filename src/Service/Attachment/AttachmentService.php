<?php
namespace App\Service\Attachment;

use App\Entity\Attachment;
use App\Entity\Product;
use App\Repository\AttachmentRepository;

class AttachmentService implements AttachmentServiceInterface
{
    private $attachmentRepository;

    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }

    public function addAttachments($files, $directory, Product $product, $entityManager)
    {
        foreach ($files as $file) {
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($directory, $filename);
            $attachment = new Attachment();
            $attachment->setProduct($product);
            $attachment->setImage($filename);
            $entityManager->persist($attachment);
        }
    }

    public function getAttachments()
    {
        return $this->attachmentRepository->findAll();
    }
}