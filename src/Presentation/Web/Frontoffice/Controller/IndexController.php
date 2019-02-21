<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Presentation\Web\Frontoffice\Controller;

use App\Application\Command\CreateRoomTripItem\CreateRoomTripItemCommand;
use App\Presentation\Web\Frontoffice\Form\RoomTripItemFormType;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class indexController.
 */
final class IndexController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * IndexController constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/forms", name="app.routes.forms")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $createRoomTripItemCommand     = new CreateRoomTripItemCommand();
        $createRoomTripItemCommand->id = Uuid::uuid4();

        $form = $this->createForm(RoomTripItemFormType::class, $createRoomTripItemCommand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createRoomTripItemCommand = $form->getData();

            $this->commandBus->handle($createRoomTripItemCommand);
        }

        return $this->render('Frontoffice/index.html.twig', ['form' => $form->createView()]);
    }
}
