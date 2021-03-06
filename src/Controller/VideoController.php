<?php


namespace App\Controller;


use App\Entity\Video;
use App\Form\VideoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
	/**
	 * @Route ("/change-video/{id}-{slug}", name="change.video")
	 * @IsGranted ("ROLE_USER")
	 * @param $slug
	 * @param Video $video
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function changeImage(Video $video, $slug, Request $request)
	{
		$form = $this->createForm(VideoType::class, $video);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$videoUrl = $form->get('urlVideo')->getData();
			$videoId = explode('=', $videoUrl);
			$videoName = $videoId[1];

			$video->setUrlVideo($videoName);

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'La vidéo a bien été ajouté !');
			return $this->redirectToRoute('trick.edit', ['slug' => $slug]);
		}

		return $this->render('pages/changeVideo.html.twig', [
			'video' => $video,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/delete-video/{id}-{slug}", name="delete.video")
	 * @IsGranted ("ROLE_USER")
	 * @param $slug
	 *
	 * @param Video $video
	 *
	 * @return RedirectResponse
	 */
	public function deleteImage(Video $video, $slug)
	{
		$manager = $this->getDoctrine()->getManager();
		$manager->remove($video);
		$manager->flush();

		$this->addFlash('success', 'La vidéo a bien été supprimé !');

		return $this->redirectToRoute('trick.edit', ['slug' => $slug]);
	}


}