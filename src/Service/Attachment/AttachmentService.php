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

    public function addAttachments($files, $directory, Product $product, $entityManager, $request)
    {
        foreach ($files as $file) {
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($directory, $filename);
            $attachment = new Attachment();
            $attachment->setProduct($product);
            $attachment->setImage($filename);
            if($file == $files[count($files) - 1]) {
                $attachment->setIsPrimary(true);
            }
            
            $entityManager->persist($attachment);
        }
        
    }

    public function getAttachments()
    {
        return $this->attachmentRepository->findAll();
    }

    public function getAllByOneProduct(Product $product)
    {
        return $this->attachmentRepository->findBy(['product' => $product]);
    }

    public function getPrimaryImage(Product $product)
    {
        $attachments = $this->getAllByOneProduct($product);
        foreach ($attachments as $attachment) {
            if($attachment->isPrimary()) {
                return $attachment;
            }
        }
        return null;
    }

    public function getNamesByProduct(Product $product)
    {
        $attachments = $this->attachmentRepository->findBy((['product' => $product]));
        $names = [];
        foreach ($attachments as $attachment) {
            $name = $attachment->getImage();
            $names[] = $name;
        }
        return $names;
    }
}