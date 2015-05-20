<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\EndLocation;
use ApiBundle\Entity\Location;
use ApiBundle\Entity\Maze;
use ApiBundle\Entity\StartLocation;
use ApiBundle\Exception\ApiException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MazeController extends Controller
{
    /**
     * Generate a new maze.
     *
     * @param Request $request
     *
     * @Route("/maze/generate", name="api.maze.generate")
     * @Method({"POST"})
     *
     * @return Response
     */
    public function generateNewMaze(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);

        $maze = $this->processNewMazeMetadata($requestContent);
        $maze = $this->processLocationMetadata($maze, $requestContent);

        $this->get('api.maze.service')->generateNewMaze($maze);

        $maze = $this->get('jms_serializer')->serialize($maze, 'json');

        return new Response($maze);
    }

    /**
     * @param int $id
     *
     * @Route("/maze/display/{id}", name="api.maze.display")
     * @Method({"GET"})
     *
     * @return Response
     * @throws ApiException
     */
    public function displayMapAsAsciiAction($id)
    {
        $maze = $this->get('api.maze.service')->findOneById($id);

        if (null === $maze) {
            throw new ApiException('The provided maze ID does not exist');
        }

        $mazeAsArray = $this->get('api.maze.service')->getMazeAsArray($maze);
        $mazeOutput  = $this->get('api.maze.service')->displayMap($mazeAsArray);
        $mazeOutput  = '<pre>' . $mazeOutput;

        return new Response($mazeOutput);
    }

    protected function processLocationMetadata(Maze $maze, array $requestParameters)
    {
        $startPoint = new StartLocation();
        $startPoint->setMaze($maze);

        $endPoint = new EndLocation();
        $endPoint->setMaze($maze);

        if (array_key_exists('startPointX', $requestParameters)) {
            $startPoint->setXCoordinate($requestParameters['startPointX']);
        } else {
            throw new ApiException("Start point X undefined.");
        }

        if (array_key_exists('startPointY', $requestParameters)) {
            $startPoint->setYCoordinate($requestParameters['startPointY']);
        } else {
            throw new ApiException("Start point Y undefined.");
        }

        if (array_key_exists('endPointX', $requestParameters)) {
            $endPoint->setXCoordinate($requestParameters['endPointX']);
        } else {
            throw new ApiException("End point X undefined.");
        }

        if (array_key_exists('endPointY', $requestParameters)) {
            $endPoint->setYCoordinate($requestParameters['endPointY']);
        } else {
            throw new ApiException("End point Y undefined.");
        }

        $manager = $this->get('doctrine')->getManager();

        $manager->persist($startPoint);
        $manager->persist($endPoint);

        $manager->flush();

        $maze->setStartLocation($startPoint);
        $maze->setEndLocation($endPoint);

        return $maze;
    }

    /**
     * @param array $requestParameters
     *
     * @return Maze
     * @internal param Maze $maze
     */
    protected function processNewMazeMetadata(array $requestParameters)
    {
        $maze = new Maze();

        if (array_key_exists('width', $requestParameters)) {
            $maze->setWidth($requestParameters['width']);
        } else {
            $maze->setWidth(10);
        }

        if (array_key_exists('height', $requestParameters)) {
            $maze->setHeight($requestParameters['height']);
        } else {
            $maze->setHeight(10);
        }

        if (array_key_exists('brick_density', $requestParameters)) {
            $maze->setBrickDensity($requestParameters['brick_density']);
        } else {
            $maze->setBrickDensity(50);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($maze);
        $manager->flush();

        return $maze;
    }
}
