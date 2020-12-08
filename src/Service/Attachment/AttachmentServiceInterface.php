<?php
namespace App\Service\Attachment;

use App\Entity\Product;

interface AttachmentServiceInterface
{
    public function addAttachments($directory, Product $product, $entityManager, $form);

    public function addToDirectory($file, $directory, $product, $entityManager);

    public function getAttachments();

    public function getAllByOneProduct(Product $product);

    public function getPrimaryImage(Product $product);

    public function getNamesByProduct(Product $product);
}