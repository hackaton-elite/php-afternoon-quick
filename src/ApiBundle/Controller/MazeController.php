<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Maze;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MazeController extends Controller
{
    /**
     * Generate a new maze.
     *
     * @param Request $request
     *
     * @Route("/maze/generate", name="api.maze.generate")
     * @Method({"POST"})
     */
    public function generateNewMaze(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);

        $maze = new Maze();
        $maze = $this->processNewMazeMetadata($maze, $requestContent);
    }

    /**
     * @param Maze  $maze
     * @param array $requestParameters
     */
    protected function processNewMazeMetadata(Maze $maze, array $requestParameters)
    {
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
    }
}
