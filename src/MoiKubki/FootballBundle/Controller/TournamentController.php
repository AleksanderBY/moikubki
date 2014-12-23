<?php

namespace MoiKubki\FootballBundle\Controller;


use MoiKubki\FootballBundle\Entity\Group;
use MoiKubki\FootballBundle\Entity\Stage;
use MoiKubki\FootballBundle\Entity\TeamFC;
use MoiKubki\FootballBundle\Entity\Tournament;
use MoiKubki\FootballBundle\Form\Type\TournamentType;
use MoiKubki\HomeBundle\Entity\AdminUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;


class TournamentController extends Controller
{
    //Добавляем новый турнир
    public function newAction(Request $request)
    {
        $tournament = new Tournament();
        $form = $this->createForm(new TournamentType(), $tournament);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // получаем текущего пользователя из контекст
                $user = $this->get('security.context')->getToken()->getUser();

                $tournament->setCreator($user->getId())
                    ->setDateCreate(new \DateTime('now'));
                //создаем этап по умолчанию
                $stage = new Stage();
                $stage->setName('Регулярка')->setTournament($tournament);

                //создаем группу по умочание для дефолтного этапа
                $group = new Group();
                $group->setName('default')->setStage($stage);

                $em = $this->getDoctrine()->getManager();

                $em->persist($tournament);
                $em->persist($stage);
                $em->persist($group);
                $em->flush();

                // creating the ACL
                $aclProvider = $this->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($tournament);
                $acl = $aclProvider->createAcl($objectIdentity);

                // retrieving the security identity of the currently logged-in user
                $securityContext = $this->get('security.context');
                $user = $securityContext->getToken()->getUser();
                $securityIdentity = UserSecurityIdentity::fromAccount($user);

                // grant owner access
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);

                return $this->redirect($this->generateUrl('moi_kubki_football_edit', array('ID' => $tournament->getId())));
            }
        }

        return $this->render('MoiKubkiFootballBundle:tournament:new.html.twig', array('form' => $form->createView()));
    }

    //Редактирование и настройка турнира ЗАГЛУШКА
    public function editAction($ID)
    {
        return $this->render('MoiKubkiFootballBundle:tournament:edit.html.twig', array('ID' =>$ID));
    }

    //Редактирование списка команд турнира
    public function editTeamsAction($ID)
    {
        return $this->render('MoiKubkiFootballBundle:tournament:editTeams.html.twig', array('ID' =>$ID));
    }

    //Добавление команды в базу
    public function addTeamAction(Request $request)
    {
        if ($request->getMethod() == 'POST')
        {
            $country = $request->get('country');
            $adminarea1= $request->get('adminarea1');
            $adminarea2= $request->get('adminarea2');
            $locality = $request->get('locality');
            $sublocality = $request->get('sublocality');
            $name = $request->get('name');
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('MoiKubkiHomeBundle:AdminUnit');
            $query = $repository->createQueryBuilder('p')
                ->where('p.country = :country AND p.adminarea1 = :adminarea1 AND p.adminarea2 = :adminarea2 AND p.locality = :locality AND p.sublocality = :sublocality')
                ->setParameters(array('country' => $country , 'adminarea1' => $adminarea1, 'adminarea2' => $adminarea2, 'locality' => $locality, 'sublocality' =>$sublocality))
                ->setMaxResults(1)
                ->getQuery();
            try {
                $adminUnit = $query->getSingleResult();
            } catch (\Doctrine\Orm\NoResultException $e) {
                $adminUnit = new AdminUnit();
                $adminUnit->setCountry($country)->setAdminarea1($adminarea1)->setAdminarea2($adminarea2)->setLocality($locality)->setSublocality($sublocality);
                $em->persist($adminUnit);
            }


            $team = new TeamFC();
            $team->setName($name);
            $team->setAdminUnit($adminUnit);
            $em->persist($team);
            $em->flush();

            return new Response($country.' '.$adminarea1.' '.$adminarea2. ' '.$locality.' '.$sublocality);
        }
        return new Response('Это не POST');

    }
} 