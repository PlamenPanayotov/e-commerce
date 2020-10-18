<?php
namespace App\Service\Attachment;

use App\Entity\Product;

interface AttachmentServiceInterface
{
    public function addAttachments($files, $directory, Product $product, $entityManager);

    public function getAttachments();
}