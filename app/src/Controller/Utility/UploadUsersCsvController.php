<?php

namespace App\Controller\Utility;

use App\Form\UploadUsersCsvForm;
use App\Service\UploadUsersCsvLoader;
use App\Service\UploadUsersCsvPersister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

#[Route('/utility')]
class UploadUsersCsvController extends AbstractController
{
    private UploadUsersCsvLoader $uploadUsersCsvLoader;
    private UploadUsersCsvPersister $uploadUsersCsvPersister;

    public function __construct(
        UploadUsersCsvLoader $uploadUsersCsvLoader,
        UploadUsersCsvPersister $uploadUsersCsvPersister
    ) {
        $this->uploadUsersCsvLoader = $uploadUsersCsvLoader;
        $this->uploadUsersCsvPersister = $uploadUsersCsvPersister;
    }

    #[Route('/upload/users/csv', name: 'app_utility_upload_users_csv')]
    public function index(Request $request): Response
    {
        $csv_data = [];
        $form = $this->createForm(UploadUsersCsvForm::class);
        $form->handleRequest($request);

        return $this->render('utility_upload_users_csv/index.html.twig', [
            'controller_name' => 'UploadUsersCsvController',
        ]);
    }

    private function getSheetData(UploadedFile $uploadedFile): array
    {

    }
}
