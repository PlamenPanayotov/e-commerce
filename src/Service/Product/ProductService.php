<?php
namespace App\Service\Product;

use App\Entity\Product;
use App\Repository\ProductTranslationRepository;
use App\Service\Attachment\AttachmentServiceInterface;
use Proxies\__CG__\App\Entity\Attachment;
use Symfony\Component\Filesystem\Filesystem;

class ProductService implements ProductServiceInterface
{
    private $productTranslationRepository;
    private $productOptionService;
    private $attachmentService;

    public function __construct(ProductTranslationRepository $productTranslationRepository,
                                ProductOptionServiceInterface $productOptionService,
                                AttachmentServiceInterface $attachmentService)
    {
        $this->productTranslationRepository = $productTranslationRepository;
        $this->productOptionService = $productOptionService;
        $this->attachmentService = $attachmentService;
    }

    public function deleteProduct(Product $product, $entityManager, $dir)
    {
        $productTranslations = $this->productTranslationRepository->findBy(['product' => $product->getId()]);
        $productOptions = $this->productOptionService->getProductOptionsByProduct($product->getId());
        $attachments = $this->attachmentService->getAllByOneProduct($product);

        foreach ($attachments as $attachment) {
            $filesystem = new Filesystem();
            $filename = $attachment->getImage();
            $filesystem->remove($dir . $filename);
            $entityManager->remove($attachment);
        }

        foreach ($productOptions as $productOption) {
            $entityManager->remove($productOption);
        }

        foreach ($productTranslations as $productTranslation) {
            $entityManager->remove($productTranslation);
        }

        $entityManager->remove($product);
    }
}