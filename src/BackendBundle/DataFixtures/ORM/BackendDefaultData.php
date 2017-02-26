<?php

namespace BackendBundle\DataFixtures\ORM;

use BackendBundle\Service\Db\CategoryService;
use BackendBundle\Service\Db\ProductService;
use CoreBundle\Model\CategoryBuilder;
use CoreBundle\Model\ImageBuilder;
use CoreBundle\Model\PathBuilder;
use CoreBundle\Model\ProductBuilder;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Repository\ImageRepository;
use CoreBundle\Repository\ProductRepository;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class BackendDefaultData implements FixtureInterface
{

    /**
     * @var EntityManager
     */
    private $entityManger;

    private $productRepository;
    private $categoryRepository;
    private $imageRepository;

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var ProductService
     */
    private $productService;

    public function load(ObjectManager $manager)
    {
        $this->entityManger = $manager;
        $this->initRepositories();
        $this->initServices();
        $this->loadDefaultCategories();
        $this->loadDefaultProducts();
    }

    private function initRepositories()
    {
        $this->productRepository = new ProductRepository($this->entityManger);
        $this->categoryRepository = new CategoryRepository($this->entityManger);
        $this->imageRepository = new ImageRepository($this->entityManger);
    }

    private function initServices()
    {
        $this->productService = new ProductService($this->entityManger, $this->productRepository, $this->categoryRepository, $this->imageRepository);
        $this->categoryService = new CategoryService($this->entityManger, $this->categoryRepository);
    }

    private function loadDefaultCategories()
    {
        $paths = array();
        $paths[] = PathBuilder::create('PC components')->createChild('Hard drives')->createChild('SSD')->build();
        $paths[] = PathBuilder::create('PC components')->createChild('Hard drives')->createChild('External SSD')->build();
        $paths[] = PathBuilder::create('PC components')->createChild('Hard drives')->createChild('Server hard drives')->build();

        $paths[] = PathBuilder::create('Notebooks & Tablets')->createChild('Notebooks')->build();
        $paths[] = PathBuilder::create('Notebooks & Tablets')->createChild('Tablets')->build();

        $paths[] = PathBuilder::create('Peripherals')->createChild('Monitors')->build();
        $paths[] = PathBuilder::create('Peripherals')->createChild('Monitors')->createChild('Curved Monitors')->build();
        $paths[] = PathBuilder::create('Peripherals')->createChild('Monitors')->createChild('4K Monitors')->build();

        $paths[] = PathBuilder::create('Peripherals')->createChild('Keyboard & Mice')->createChild('Mice')->build();
        $paths[] = PathBuilder::create('Peripherals')->createChild('Keyboard & Mice')->createChild('Keyboards')->build();

        foreach ($paths as $path) {
            $this->categoryService->create($path);
        }
    }

    private function loadDefaultProducts()
    {
        $defaultDescription = 'Lorem ipsum dolor sit amete, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores';
        $defaultImage = ImageBuilder::instance()->setBinary(file_get_contents('./web/images/no-product.jpg'))->build();
        $products = array();

        $category = CategoryBuilder::instance()->setPath(PathBuilder::createByPath('/'))->build();
        $products[] = ProductBuilder::instance()->setName('Samsung 850 Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(462)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Samsung 950 Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(723)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('ASUS ROG Gaming')->setDescription($defaultDescription)->setCategory($category)->setPrice(899)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('BenQ SW320')->setDescription($defaultDescription)->setCategory($category)->setPrice(1499)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Apple MacBook Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(2599)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Microsoft Surface Pro 4')->setDescription($defaultDescription)->setCategory($category)->setPrice(1199)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Apple iPad Air 2')->setDescription($defaultDescription)->setCategory($category)->setPrice(499)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Samsung Galaxy Tab A')->setDescription($defaultDescription)->setCategory($category)->setPrice(299)->setImage($defaultImage)->build();

        $category = CategoryBuilder::instance()->setPath(PathBuilder::createByPath('/PC components/Hard drives/SSD'))->build();
        $products[] = ProductBuilder::instance()->setName('Samsung 850 Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(462)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Samsung 950 Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(723)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Samsung 200 Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(256)->setImage($defaultImage)->build();

        $category = CategoryBuilder::instance()->setPath(PathBuilder::createByPath('/Peripherals/Monitors/4K Monitors'))->build();
        $products[] = ProductBuilder::instance()->setName('ASUS ROG Gaming')->setDescription($defaultDescription)->setCategory($category)->setPrice(899)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('BenQ SW320')->setDescription($defaultDescription)->setCategory($category)->setPrice(1499)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('NEC EA244UHD')->setDescription($defaultDescription)->setCategory($category)->setPrice(1434)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('HP Z30i')->setDescription($defaultDescription)->setCategory($category)->setPrice(1365)->setImage($defaultImage)->build();

        $category = CategoryBuilder::instance()->setPath(PathBuilder::createByPath('/Notebooks & Tablets/Notebooks'))->build();
        $products[] = ProductBuilder::instance()->setName('Apple MacBook Pro')->setDescription($defaultDescription)->setCategory($category)->setPrice(2599)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Microsoft Surface Pro 4')->setDescription($defaultDescription)->setCategory($category)->setPrice(1199)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('HP Spectre Pro x360')->setDescription($defaultDescription)->setCategory($category)->setPrice(1099)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Microsoft Surface Book')->setDescription($defaultDescription)->setCategory($category)->setPrice(1499)->setImage($defaultImage)->build();

        $category = CategoryBuilder::instance()->setPath(PathBuilder::createByPath('/Notebooks & Tablets/Tablets'))->build();
        $products[] = ProductBuilder::instance()->setName('Apple iPad Air 2')->setDescription($defaultDescription)->setCategory($category)->setPrice(499)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Samsung Galaxy Tab A')->setDescription($defaultDescription)->setCategory($category)->setPrice(299)->setImage($defaultImage)->build();
        $products[] = ProductBuilder::instance()->setName('Huawei MediaPad M3')->setDescription($defaultDescription)->setCategory($category)->setPrice(319)->setImage($defaultImage)->build();

        foreach ($products as $product) {
            $this->productService->create($product);
        }
    }

}