<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    // EntityManagerInterface est injecté automatiquement par Symfony
    // C'est l'outil principal de Doctrine pour lire/écrire en BDD

    // Route : liste de tous les articles
    #[Route('/articles', name: 'app_article_index')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer TOUS les articles depuis la BDD
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    // Route : formulaire + ajout d'un article
    #[Route('/articles/new', name: 'app_article_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {

            // 1. Créer un nouvel objet Article
            $article = new Article();

            // 2. Remplir ses propriétés avec les données du formulaire
            $article->setTitre($request->request->get('titre'));
            $article->setContenu($request->request->get('contenu'));
            $article->setCreatedAt(new \DateTimeImmutable());

            // 3. Dire à Doctrine de "surveiller" cet objet
            $em->persist($article);

            // 4. Exécuter le INSERT en base de données
            $em->flush();

            // 5. Rediriger vers la liste
            return $this->redirectToRoute('app_article_index');
        }

        return $this->render('article/new.html.twig');
    }

    // Route : voir un seul article par son id
    #[Route('/articles/{id}', name: 'app_article_show')]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        // Chercher l'article par son id
        $article = $em->getRepository(Article::class)->find($id);

        // Si l'article n'existe pas → page 404
        if (!$article) {
            throw $this->createNotFoundException('Article introuvable');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    // Route : supprimer un article
    #[Route('/articles/{id}/delete', name: 'app_article_delete')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        if ($article) {
            // Dire à Doctrine de supprimer cet objet
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('app_article_index');
    }
}