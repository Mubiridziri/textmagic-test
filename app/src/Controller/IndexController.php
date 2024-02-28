<?php

namespace App\Controller;

use App\Entity\UserTest;
use App\Service\QuestionService;
use App\Service\UserTestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route("", methods: ['GET', 'POST'])]
    public function indexAction(QuestionService $questionService, Request $request): Response
    {
        $questions = $questionService->getShuffledQuestions();

        if ($request->getMethod() === Request::METHOD_POST) {
            $formValues = $request->get("form", []);

            $error = $questionService->validate($formValues, $questions);

            if (null !== $error) {
                return $this->render('pages/index.html.twig', [
                    "questions" => $questions,
                    "error" => $error,
                    "formValues" => $formValues,
                ]);
            }

            $userTest = $questionService->getUserTestResults($formValues);
            $sortedQuestions = $questionService->sortQuestionBy($questions, $formValues);

            return $this->render('pages/index.html.twig', [
                "questions" => $sortedQuestions,
                "userTest" => $userTest,
                "formValues" => $formValues,
            ]);
        }

        return $this->render('pages/index.html.twig', [
            "questions" => $questions,
        ]);
    }

    #[Route("/user_tests", methods: ['GET'])]
    public function userTestsAction(UserTestService $userTestService): Response
    {
        $tests = $userTestService->getUserTests();
        return $this->render('pages/user_tests.html.twig', [
            "userTests" => $tests,
        ]);

    }

    #[Route("/user_tests/{id}", methods: ['GET'])]
    public function viewUserTestAction(UserTest $test): Response
    {
        return $this->render('pages/view_user_test.html.twig', [
            "userTest" => $test,
        ]);

    }
}