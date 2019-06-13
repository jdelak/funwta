<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\RegistrationType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
    	$user = New User();
    	$form = $this->createForm(RegistrationType::class, $user);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$hash = $encoder->encodePassword($user, $user->getPassword());
			$user->setPassword($hash);
			$user->addRole('ROLE_USER');
			$manager->persist($user);
			$manager->flush();

			return $this->redirectToRoute('security_login');
		}

        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(){
    	return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){

    }

    /**
     * @Route("/forgottenPassword", name="forgotten_password")
     */
    public function forgottenPassword(
        Request $request, 
        \Swift_Mailer $mailer, 
        TokenGeneratorInterface $tokenGenerator
    )
    {
        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('main');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('main');
            }

            $url = $this->generateUrl('reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

             $transport = (new \Swift_SmtpTransport('in-v3.mailjet.com', 587))
                ->setUsername('xxx')
                ->setPassword('xxx')
                ->setEncryption('tls')
                ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false))
            );
            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Demande de nouveau mot de passe'))
                ->setFrom('contact@funwta.net')
                ->setTo($user->getEmail())
                ->setBody(
                    "Bonjour,<br> Voici le lien pour définir votre nouveau votre mot de passe : <a href='" . $url . "'>Redéfinir votre mot de passe</a><br> Si vous n êtes pas à l'origine de cette action, ne cliquez pas sur le lien !",
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Mail envoyé');

            return $this->redirectToRoute('main');
        }

        return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="reset_password")
    */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('main');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('main');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

    }
}
