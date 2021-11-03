<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crud", name="crud.")
 */
class CrudController extends AbstractController
{
    /**
     * @Route("/", name="getAll")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function getAll(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('crud/all_products.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Product Created!');
            return $this->redirect($this->generateUrl('crud.details', ['id' => $product->getId()]));
        }

        return $this->render('crud/create.html.twig', [
            'product_create_form' => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}", name="details")
     * @param Product $product
     * @return Response
     */
    public function getOne(Product $product): Response
    {
        return $this->render('crud/product_details.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/update/{id}")
     */
    public function update($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('crud/product_details.html.twig', [
            'id' => $product->getId()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Product $product): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->redirect($this->generateUrl('crud.get'));
    }
}


