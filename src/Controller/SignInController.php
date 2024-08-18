<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/')]
class SignInController extends AbstractController
{
    #[Route('', name: 'app_signin')]
    public function signIn(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Check if the request method is POST (form submission)
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            // Validate the credentials (check if they are both 'admin')
            if ($username === 'admin' && $password === 'admin') {
                // Generate a token (for simplicity, we'll use a random string)
                $token = bin2hex(random_bytes(16));

                // Store the token in the session (for demonstration purposes)
                $session = $request->getSession();
                $session->set('token', $token);

                // Redirect to the /home route
                return $this->redirectToRoute('home');
            } else {
                // Add an error message if credentials are incorrect
                $error = 'Invalid credentials';
            }
        }

        return $this->render('signin/signin.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
public function logout(Request $request): Response
{
    $session = $request->getSession();
    $session->invalidate();  // Invalidate the session

    return $this->redirectToRoute('app_signin');
}

}




