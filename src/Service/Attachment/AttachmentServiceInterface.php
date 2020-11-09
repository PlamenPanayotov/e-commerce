<?php
namespace App\Service\Attachment;

use App\Entity\Product;

interface AttachmentServiceInterface
{
    public function addAttachments($files, $directory, Product $product, $entityManager, $form);

    public function getAttachments();

    public function getAllByOneProduct(Product $product);

    public function getPrimaryImage(Product $product);

    public function getNamesByProduct(Product $product);
}