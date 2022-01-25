<?php

namespace App\Security;

use App\Entity\User;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;


class LoginFormAuthenticator extends AbstractLoginFormAuthenticator {

  use TargetPathTrait;

  public const LOGIN_ROUTE = 'app_login';

  private UrlGeneratorInterface $urlGenerator;

  public function __construct(UrlGeneratorInterface $urlGenerator) {
    $this->urlGenerator = $urlGenerator;
  }

  public function authenticate(Request $request):PassportInterface {
    $email = $request->request->get('email', '');

    $request->getSession()->set(Security::LAST_USERNAME, $email);

    return new Passport(new UserBadge($email), new PasswordCredentials($request->request->get('password', '')), [new CsrfTokenBadge('authenticate', $request->get('_csrf_token')), new RememberMeBadge(),]);
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName):?Response {
    if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
      return new RedirectResponse($targetPath);
    }

    //if($this->securityContext->isGranted('ROLE_ADMIN')){

    //throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
    //    return new RedirectResponse($this->urlGenerator->generate('admon_mobilhome'));
    //}else{
    return new RedirectResponse($this->urlGenerator->generate('app_login'));
    //}

    //        $user = new User();

    //        $user = $token->getUser();

    //        if($user->getRoles() == 'ROLE_ADMIN'){
    //            return new RedirectResponse($this->urlGenerator->generate('admon_mobilhome'));
    //        }
    //        else{
    //            if($user->getRoles() == 'ROLE_USER'){
    //                return new RedirectResponse($this->urlGenerator->generate('app_login'));
    //            }
    //       try{
    //            return new RedirectResponse($this->urlGenerator->generate('admon_mobilhome'));
    //        }catch(Exception $rdm){

    //        }

    //            }
    //        }

    // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
  }

  protected function getLoginUrl(Request $request):string {
    return $this->urlGenerator->generate(self::LOGIN_ROUTE);
  }

}
