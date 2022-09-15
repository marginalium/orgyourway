<?php

namespace App\Controller\Utility;

use App\Form\UploadUsersCsvForm;
use App\Service\UploadUsersCsvLoader;
use App\Service\UploadUsersCsvPersister;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

#[Route('/utility')]
class UploadUsersCsvController extends AbstractController
{
    public function __construct(
        private UploadUsersCsvLoader $uploadUsersCsvLoader,
        private UploadUsersCsvPersister $uploadUsersCsvPersister
    ) {
    }

    #[Route('/upload/users/csv', name: 'app_utility_upload_users_csv')]
    public function index(Request $request): Response
    {
        $csvData = [];
        $form = $this->createForm(UploadUsersCsvForm::class);
        $form->handleRequest($request);

        $preview = $form->get('preview');
        $action = $preview->isClicked() ? 'preview' : 'submit';

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->getData()['file'];
            $sheetData = $this->getSheetData($file);

            $header = array_shift($sheetData);
            foreach($sheetData as $row) {
                $userArray[] = array_combine($header, $row);
            }

            $validatedUserArray = ($this->uploadUsersCsvLoader)($userArray);

            dd($validatedUserArray);
        }

        return $this->render('utility_upload_users_csv/index.html.twig', [
            'form' => $form->createView(),
            'generated' => [],
            'csvData' => $csvData,
            'controller_name' => 'UploadUsersCsvController',
        ]);
    }

    private function getSheetData(UploadedFile $uploadedFile): array
    {
        $spreadsheet = IOFactory::load($uploadedFile->getRealPath());
        return $spreadsheet->getActiveSheet()->toArray(null, true, false);
    }
}
