<?php

namespace MoiKubki\FootballBundle\Controller;


use MoiKubki\FootballBundle\Entity\Group;
use MoiKubki\FootballBundle\Entity\Stage;
use MoiKubki\FootballBundle\Entity\TeamFC;
use MoiKubki\FootballBundle\Entity\Tournament;
use MoiKubki\FootballBundle\Form\Type\TournamentType;
use MoiKubki\HomeBundle\Entity\AdminUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Expression\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Form\Tests\Extension\Csrf\CsrfProvider\DefaultCsrfProviderTest;


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
                $tokenStorage = $this->get('security.token_storage');
                $user = $tokenStorage->getToken()->getUser();
                $securityIdentity = UserSecurityIdentity::fromAccount($user);

                $builder = new MaskBuilder();
                $builder->add('edit')->add('delete');
                $mask= $builder->get();
                // grant owner access
                $acl->insertObjectAce($securityIdentity, $mask);
                $aclProvider->updateAcl($acl);

<<<<<<< HEAD

=======
>>>>>>> 73c1129a663389e70f915b6d392f68fc1a3f4de0
                return $this->redirect($this->generateUrl('moi_kubki_football_edit', array('id' => $tournament->getId())));
            }
        }

        return $this->render('MoiKubkiFootballBundle:tournament:new.html.twig', array('form' => $form->createView()));
    }


    //Редактирование и настройка турнира ЗАГЛУШКА
    public function editAction($id)
    {
<<<<<<< HEAD
        //Проверяем права на редактирование турнира
        $authorizationChecker = $this->get('security.authorization_checker');
        $tournament = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:Tournament')->find($id);
        if (false === $authorizationChecker->isGranted('EDIT', $tournament)) {
            return $this->redirect($this->generateUrl('moi_kubki_football_show', array('id'=>$id)));
        }
        else
        {
            return $this->render('MoiKubkiFootballBundle:tournament:edit.html.twig', array('id' =>$id));
        }

=======
        return $this->render('MoiKubkiFootballBundle:tournament:edit.html.twig', array('id' =>$id));
>>>>>>> 73c1129a663389e70f915b6d392f68fc1a3f4de0
    }

    //Редактирование списка команд турнира
    public function editTeamsAction(Request $request, $id)
    {
        //Проверяем права на редактирование турнира
        $authorizationChecker = $this->get('security.authorization_checker');
        $tournament = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:Tournament')->find($id);
        if (false === $authorizationChecker->isGranted('EDIT', $tournament)) {
            return $this->redirect($this->generateUrl('moi_kubki_football_show', array('id'=>$id)));
        }
        else
        {
            return $this->render('MoiKubkiFootballBundle:tournament:editTeams.html.twig', array('id' => $id, 'tournament' => $tournament));
        }


    }

    //Добавление команды в базу
    public function addTeamAction(Request $request)
    {


        //Проверяем метод запроса
        if ($request->getMethod() == 'POST')
        {
            //Проверяет данные
            $id = $request->get('id');
            if ($id !== '')
            {
                //проверяем токен
                $token = $request->get('_token');
                if ($this->get('form.csrf_provider')->isCsrfTokenValid('intention', $token))
                {
                    //получаем данные и запроса

                    $name = $request->get('name');
                    if ($name !== '')
                    {
                        $em = $this->getDoctrine()->getManager();
                        $query = $em->getRepository('MoiKubkiFootballBundle:TeamFC')
                        ->createQueryBuilder('p')
                        ->where('p.name = :name AND p.tournament = :tournament')
                        ->setParameters(array('name' => $name , 'tournament' => $id))
                        ->setMaxResults(1)
                        ->getQuery();
                        $team = $query->getResult();
                        if ($team) {
                            return new Response('Команда с таким название в уже внесена в турнир');
                        }
                        $country = $request->get('country');
                        $adminarea1= $request->get('adminarea1');
                        $adminarea2= $request->get('adminarea2');
                        $locality = $request->get('locality');
                        $sublocality = $request->get('sublocality');

                        $repository = $em->getRepository('MoiKubkiHomeBundle:AdminUnit');
                        $query = $repository->createQueryBuilder('p')
                            ->where('p.country = :country AND p.administrative_area_level_1 = :adminarea1 AND p.administrative_area_level_2 = :adminarea2 AND p.locality = :locality AND p.sublocality = :sublocality')
                            ->setParameters(array('country' => $country , 'adminarea1' => $adminarea1, 'adminarea2' => $adminarea2, 'locality' => $locality, 'sublocality' =>$sublocality))
                            ->setMaxResults(1)
                            ->getQuery();
                        try {
                            $adminUnit = $query->getSingleResult();
                        } catch (\Doctrine\Orm\NoResultException $e) {
                            $adminUnit = new AdminUnit();
                            $adminUnit->setCountry($country)->setAdministrativeAreaLevel1($adminarea1)->setAdministrativeAreaLevel2($adminarea2)->setLocality($locality)->setSublocality($sublocality);
                            $em->persist($adminUnit);
                        }
                        $tournament = $em->getRepository('MoiKubkiFootballBundle:Tournament')
                            ->find($id);
                        if (!$tournament)
                        {
                            return new Response('Неверный ид турнира');
                        }
                        $team = new TeamFC();
                        $team->setName($name);
                        $team->setAdminUnit($adminUnit);
                        $team->setTournament($tournament);
                        $em->persist($team);
                        $em->flush();
                        return new Response('Команда добавленна');
                    }
                    else
                    {
                        return new Response('Не введено название команды');
                    }
                }
                else
                {
                    return new Response('Недействительный токен');
                }
            }
        }
        return $this->render('MoiKubkiFootballBundle:Tournament:addTeam.html.twig');
    }

    //Извлечение команды для турнира из базы
    public function getTeamsFromTournamentAction($id, Request $request)
    {
        if ($request->getMethod() == 'POST')
        {
            $data = $request->get('filter');
            $teams = $this->getDoctrine()->getManager()->getRepository('MoiKubkiFootballBundle:TeamFC')->
                createQueryBuilder('p')
                ->where('p.name LIKE :filter AND p.tournament = :id')
                ->setParameters(array('filter' => '%'.$data.'%', 'id' => $id))
                ->getQuery()
                ->getResult();

        }
        else $teams =  $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:TeamFC')->findBy(array('tournament'=>$id));

        return $this->render('MoiKubkiFootballBundle:Tournament:getTeamsFromTournament.html.twig', array('teams' => $teams ));
    }

    public function showAction($id)
    {
        return new Response('Здесь показываем турнир');
    }
} 