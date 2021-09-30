<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\ArticleRepository;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    
    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE)
            return null;
        if ($data === null)
            return $request;
        $request->request->replace($data);
        return $request;
    }

    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findALl();
            
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($articles);
            return new JsonResponse(["data"=> $formatted]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $request = $this->transformJsonBody($request);

        $article = new Article();

        
        $article->setTitle($request->get("title"));
       
        $article->setDescription($request->get("description"));
        $article->setCategory($request->get("category"));

        $article->setIsactive(true);
        $date=new \DateTime('now', (new \DateTimeZone('Africa/Tunis')));
        $article->setDate($date);

        $article->setImage($request->get("image"));
      
       

        

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($article);
            return new JsonResponse(["data"=> $formatted,"Status"=>"Create"]);
    }
    /**
     * @Route("/upload", name="uploadimag", methods={"GET","POST"})
     */
    public function upload(Request $request): Response
    {
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $request->get("image"));
      
        $image_type_aux = explode("image/", $image_parts[0]);
         
        $image_type = $image_type_aux[1];
       
        $image_base64 = base64_decode($image_parts[1]);
        
        $file = $folderPath.uniqid() . '.png';
        
        file_put_contents($file, $image_base64);
        $imagename= substr($file, 8, strlen($file));;
        
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($imagename);
        return new JsonResponse( $formatted);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Request $request): Response
    {
        $article = $this->getDoctrine()
        ->getRepository(Article::class)
        ->find($request->get("id"));

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($article);
        return new JsonResponse(["data"=> $formatted,"Status"=>"Create"]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"PUT"})
     */
    public function edit(Request $request, Article $article): Response
    {

        $request = $this->transformJsonBody($request);
        $article = $this->getDoctrine()
        ->getRepository(Article::class)
        ->find($request->get("id"));
        
        $article->setTitle($request->get("title"));
       
        $article->setDescription($request->get("description"));
        $article->setCategory($request->get("category"));

        $article->setIsactive($request->get("isactive"));
        

        $article->setImage($request->get("image"));
            $this->getDoctrine()->getManager()->flush();

            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($article);
            return new JsonResponse(["data"=> $formatted,"Status"=>"updated"]);
    }

    /**
     * @Route("/delete/{id}", name="articledelete", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $article = $this->getDoctrine()
        ->getRepository(Article::class)
        ->find($id+0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        

            return new JsonResponse(["Status"=>"deleted"]);    }
}
