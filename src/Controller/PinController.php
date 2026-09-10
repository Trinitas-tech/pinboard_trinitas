<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Entity\User;
use App\Form\PinType;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pin')]
class PinController extends AbstractController
{
    #[Route('', name: 'app_pin_index', methods: ['GET'])]
    public function index(PinRepository $pinRepository): Response
    {
        return $this->render('pin/index.html.twig', [
            'pins' => $pinRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/create', name: 'app_pin_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pin = new Pin();
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if (!$user instanceof User) {
                throw $this->createAccessDeniedException();
            }

            $pin->setUser($user);
            $entityManager->persist($pin);
            $entityManager->flush();

            $this->addFlash('success', 'Pin cree avec succes.');

            return $this->redirectToRoute('app_pin_show', ['id' => $pin->getId()]);
        }

        return $this->render('pin/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pin_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', [
            'pin' => $pin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pin_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Pin $pin, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('PIN_EDIT', $pin);

        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Pin modifie avec succes.');

            return $this->redirectToRoute('app_pin_show', ['id' => $pin->getId()]);
        }

        return $this->render('pin/edit.html.twig', [
            'form' => $form,
            'pin' => $pin,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_pin_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Pin $pin, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('PIN_EDIT', $pin);

        if ($this->isCsrfTokenValid('delete_pin_' . $pin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pin);
            $entityManager->flush();
            $this->addFlash('danger', 'Pin supprime avec succes.');
        } else {
            $this->addFlash('danger', 'Token de suppression invalide.');
        }

        return $this->redirectToRoute('app_pin_index');
    }
}
