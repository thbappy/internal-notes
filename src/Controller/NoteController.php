<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("/notes", name="note_index")
     */
    public function index(NoteRepository $noteRepository)
    {
        // Get only current user's notes
        $user = $this->getUser();
        $notes = $noteRepository->findByUser($user);

        return $this->render('note/index.html.twig', [
            'notes' => $notes
        ]);
    }

    /**
     * @Route("/notes/new", name="note_new")
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Auto-assign to current user
            $note->setUser($this->getUser());
            $em->persist($note);
            $em->flush();

            $this->addFlash('success', 'Note created successfully!');
            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/notes/{id}/edit", name="note_edit")
     */
    public function edit(Note $note, Request $request, EntityManagerInterface $em, NoteRepository $noteRepository)
    {
        // Verify note belongs to current user
        $user = $this->getUser();
        if (!$noteRepository->findByIdAndUser($note->getId(), $user)) {
            throw $this->createAccessDeniedException('You cannot edit this note.');
        }

        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Note updated successfully!');
            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/notes/{id}/delete", name="note_delete", methods={"POST"})
     */
    public function delete(Note $note, EntityManagerInterface $em, NoteRepository $noteRepository)
    {
        // Verify note belongs to current user
        $user = $this->getUser();
        if (!$noteRepository->findByIdAndUser($note->getId(), $user)) {
            throw $this->createAccessDeniedException('You cannot delete this note.');
        }

        $em->remove($note);
        $em->flush();

        $this->addFlash('success', 'Note deleted successfully!');
        return $this->redirectToRoute('note_index');
    }
}
