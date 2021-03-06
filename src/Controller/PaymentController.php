<?php

namespace App\Controller;

use App\Form\CreditType;
use App\Form\KeywordSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Export;
use App\Service\Fetching;
use App\Service\Payment;
use App\Service\PhpParser;

class PaymentController extends AbstractController
{
    /**
     * @Route("/pay/", name="app_pay")
     */
    public function indexListPrice(Payment $payment,Request $request, PhpParser $phpParser): Response
    {

        $form = $this->createForm(CreditType::class);
        
        $form->handleRequest($request);

        $credit = 0 ; 
        $price = 0; 
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $credit = $form->getData()['credit']; 

            $coeff = 0 ; 

            if ( $credit <= 1000 ) {
                $price = $credit * 0.17 ; 
            }

            if ( $credit >= 2000 ) {
                $price = $credit * 0.15 ; 
            }

            if ( $credit >= 4000 ) {
                $price = $credit * 0.14 ; 
            }

            if ( $credit >= 10000 ) {
                $price = $credit * 0.05 ; 
            }
        }


        return $this->render('Payment/payment.html.twig', [
            'form' => $form->createView(),
            'credit' => $credit,
            'price' => $price,
        ]);
    }

    /**
     * @Route("valid/pay/", name="succes_pay")
     */
    public function succesPayment(Payment $payment,Request $request, PhpParser $phpParser): Response
    {

        return $this->render('Payment/SuccesPayment.html.twig', [
          
        ]);
    }

    /**
     * @Route("invalid/pay/", name="invalid_pay")
     */
    public function invalidPayment(Payment $payment,Request $request, PhpParser $phpParser): Response
    {

        return $this->render('Payment/InvalidPayment.html.twig', [
          
        ]);
    }
}
