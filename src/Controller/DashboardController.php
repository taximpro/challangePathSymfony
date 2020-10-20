<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\User;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index()
    {


        if($this->getUser()->getStatus()=='Admin'){
            $ordersRepository = $this->getDoctrine()->getRepository(Orders::class);
            $orders = $ordersRepository->findAll();

            $status = 'Admin';
        }
        else {
            $ordersRepository = $this->getDoctrine()->getRepository(Orders::class);
            $orders = $ordersRepository->findBy([
                'customerId' =>$this->getUser()->getId()
            ]);
            $status = 'Customer';
        }



        return $this->render('dashboard/index.html.twig', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    /**
     * @Route("/orders/create", name="create_order")
     */
    public function createOrder(){
        $productRespository = $this->getDoctrine()->getRepository(Products::class);
        $products = $productRespository->findAll();

        return $this->render('dashboard/create.html.twig', [
            'products' => $products,
        ]);
    }


    /**
     * @Route("/orders/update/{id}", name="update_order")
     */
    public function updateOrder($id){


        $orderRespository = $this->getDoctrine()->getRepository(Orders::class);
        $order = $orderRespository->find($id);



        $productRespository = $this->getDoctrine()->getRepository(Products::class);
        $products = $productRespository->findAll();

        $clientRespository = $this->getDoctrine()->getRepository(User::class);
        $clients = $clientRespository->find($order->getCustomerId());
        //dd($clients);

        return $this->render('dashboard/update.html.twig', [
            'order' => $order,
            'products' => $products,
            'client' => $clients,
        ]);
    }


    /**
     * @Route("/orders/update-action/{id}", name="update_order_action")
     */
    public function updateOrderAction($id ,Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        $orderRespository = $entityManager->getRepository(Orders::class);
        $orders = $orderRespository->find($id);

        $date = new DateTime($orders->getShippingDate());
        $now = new DateTime();

        if($date < $now) {
            return new Response(sprintf('You cant edit this order because shipping date is passed  <a href="/">Go To List</a>'));
        }

        $orders ->setAddress($request->request->get('address'))
            ->setProductId($request->request->get('product'))
            ->setQuantity($request->request->get('quantity'))->setShippingDate( date('d-m-Y', strtotime('+1 week')));
        $entityManager->persist($orders);
        $entityManager->flush();

        return new Response(sprintf('Order has been updated succesfully <a href="/">Go To List</a>'));

    }



    /**
     * @Route("/orders/create-action", name="create_order_action")
     */
    public function createOrderAction(Request $request){

        //$product = new Products();

        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Products::class)->find($request->request->get('product'));


        //dd($request->request->get('quantity'));
        $entityManager = $this->getDoctrine()->getManager();
        $orders = new Orders();
        $orders ->setAddress($request->request->get('address'))
            ->setCustomerId($this->getUser()->getId())->setProduct($product)->setOrderCode(random_int(100, 400))
            ->setQuantity($request->request->get('quantity'))->setShippingDate( date('d-m-Y', strtotime('+1 week')))->setProductId(3);
        $entityManager->persist($orders);
        $entityManager->flush();

        return new Response(sprintf('Order has been created succesfully <a href="/">Go To List</a>'));
    }


    /**
     * @Route("/orders/delete/{id}", name="delete_order")
     */
    public function deleteOrder($id, Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        $order = $entityManager->getRepository(Orders::class)->find($id);

        if(!$order) {
            return $this->createNotFoundException('Order doesnt exist');
        }
        $entityManager->remove($order);
        $entityManager->flush();

        return new Response(sprintf('Order has been deleted succesfully <a href="/">Go To List</a>'));
    }


}
