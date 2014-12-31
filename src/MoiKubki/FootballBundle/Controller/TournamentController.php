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


                return $this->redirect($this->generateUrl('moi_kubki_football_edit', array('id' => $tournament->getId())));
            }
        }

        return $this->render('MoiKubkiFootballBundle:tournament:new.html.twig', array('form' => $form->createView()));
    }


    //Редактирование и настройка турнира ЗАГЛУШКА
    public function editAction($id)
    {
        $tournament = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:Tournament')->find($id);
        if (!$tournament)
        {
          return new Response('Турнир не найден');
        }
        //Проверяем права на редактирование турнира
        $authorizationChecker = $this->get('security.authorization_checker');
        if (false === $authorizationChecker->isGranted('EDIT', $tournament)) {
            return $this->redirect($this->generateUrl('moi_kubki_football_show', array('id'=>$id)));
        }
        else
        {
            return $this->render('MoiKubkiFootballBundle:tournament:edit.html.twig', array('id' =>$id));
        }

    }

    //Редактирование списка команд турнира
    public function editTeamsAction(Request $request, $id)
    {

        $tournament = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:Tournament')->find($id);
        if (!$tournament)
        {
            return new Response('Турнир не найден', 404);
        }
        //Проверяем права на редактирование турнира
        $authorizationChecker = $this->get('security.authorization_checker');
        if (false === $authorizationChecker->isGranted('EDIT', $tournament)) {
            return $this->redirect($this->generateUrl('moi_kubki_football_show', array('id'=>$id)));
        }
        else
        {
            //Генерим токен для турнира
            $tournament_token = 'tournament'.$id;
            $this->get('form.csrf_provider')->generateCsrfToken('tournament'.$id);
            return $this->render('MoiKubkiFootballBundle:tournament:editTeams.html.twig', array('id' => $id, 'tournament' => $tournament, 'tournament_token' => $tournament_token));
        }
    }

    //Добавление команды в базу
    public function addTeamAction(Request $request)
    {
        //Проверяем метод запроса
        if ($request->getMethod() == 'POST')
        {

            //Считываем и проверяем целостность данных запроса
            $country = $request->get('country');
            $adminarea1= $request->get('adminarea1');
            $adminarea2= $request->get('adminarea2');
            $locality = $request->get('locality');
            $sublocality = $request->get('sublocality');
            $id_admin = $request->get('id_admin');
            $token = $request->get('_token');
            $id = $request->get('id');
            $name = $request->get('name');

            if (!isset($id_admin, $id, $country, $adminarea1, $adminarea2, $locality, $sublocality, $token, $name))
            {
                return new Response('Неверные параметры запроса');
            }

            //Проверяем права на редактирование турнира
            $authorizationChecker = $this->get('security.authorization_checker');
            $tournament = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:Tournament')->find($id);
            if (false === $authorizationChecker->isGranted('EDIT', $tournament)) {
                return new Response('У вас нет права редактировать турнир');
            }

            //Считываем и проверяем токен
            if (!$this->get('form.csrf_provider')->isCsrfTokenValid('tournament'.$id , $token))
            {
                return new Response('Недействительный токен');
            }

            if (strlen($id_admin)!==40) {
                return new Response('Некоректно введена административная единица');
            }
            if (strlen($name) == 0)
            {
                return new Response('Не введено название команды');
            }
            //Получаем менеджер доктрины
            $em = $this->getDoctrine()->getManager();
            //Получаем репозиторий административных единиц
            $repository = $em->getRepository('MoiKubkiHomeBundle:AdminUnit');
            //Проверяем наличие админ. ед.
            $query = $repository->createQueryBuilder('p')
                ->where('p.country = :country AND p.administrative_area_level_1 = :adminarea1 AND p.administrative_area_level_2 = :adminarea2 AND p.locality = :locality AND p.sublocality = :sublocality')
                ->setParameters(array('country' => $country , 'adminarea1' => $adminarea1, 'adminarea2' => $adminarea2, 'locality' => $locality, 'sublocality' =>$sublocality))
                ->setMaxResults(1)
                ->getQuery();
            try {
                $adminUnit = $query->getSingleResult();
            } catch (\Doctrine\Orm\NoResultException $e) {
                $adminUnit = new AdminUnit();
                $adminUnit->setCountry($country)
                            ->setAdministrativeAreaLevel1($adminarea1)
                            ->setAdministrativeAreaLevel2($adminarea2)
                            ->setLocality($locality)
                            ->setSublocality($sublocality)
                            ->setGoogleId($id_admin);
                $em->persist($adminUnit);
                $em->flush();
            }

            //Проверяем наличие команды с таким название в в базе данных
            $query = $em->getRepository('MoiKubkiFootballBundle:TeamFC')
                ->createQueryBuilder('p')
                ->where('p.name = :name AND p.tournament = :tournament AND p.adminUnit = :adminUnit')
                ->setParameters(array('name' => $name , 'tournament' => $id, 'adminUnit' => $adminUnit))
                ->setMaxResults(1)
                ->getQuery();
            $team = $query->getResult();

            if ($team) {
                return new Response('Команда уже внесена в турнир ');
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

    //Удаление команды из турнира
    public function delTeamAction(Request $request)
    {
        if ($request->getMethod()!== 'POST')
        {
            return new Response('Это не POST');
        }
        $token = $request->get('_token');
        $id = $request->get('id');
        $id_team = $request->get('id_team');
        if (!isset($id, $token, $id_team))
        {
            return new Response('Неверные параметры запроса');
        }

        //Проверяем права на редактирование турнира
        $authorizationChecker = $this->get('security.authorization_checker');
        $tournament = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:Tournament')->find($id);
        if (false === $authorizationChecker->isGranted('EDIT', $tournament)) {
            return new Response('У вас нет права редактировать турнир');
        }

        //Считываем и проверяем токен
        if (!$this->get('form.csrf_provider')->isCsrfTokenValid('tournament'.$id, $token))
        {
            return new Response('Недействительный токен');
        }

        //Ищем команду и проверяем принадлежность ее к турниру
        $team = $this->getDoctrine()->getRepository('MoiKubkiFootballBundle:TeamFC')->find($id_team);
        if (!$team)
        {
            return new Response('Команда не найдена');
        }

        if ($team->getTournament()->getId()!=$id)
        {
            return new Response('Попытка удалить команду из другого турнира');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        return new Response('Удалено');
    }

    public function editStages($id)
    {
        
    }

    public function showAction($id)
    {
        return new Response('Здесь показываем турнир');
    }
} 