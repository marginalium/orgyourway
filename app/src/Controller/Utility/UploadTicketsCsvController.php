<?php

namespace App\Controller\Utility;

use App\Form\UploadTicketsCsvForm;
use App\Service\UploadTicketsCsvLoader;
use App\Service\UploadTicketsCsvPersister;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadTicketsCsvController extends AbstractController
{
    public function __construct(
        private UploadTicketsCsvLoader $uploadTicketsCsvLoader,
        private UploadTicketsCsvPersister $uploadTicketsCsvPersister
    ) {
    }

    #[Route('/utilities/upload/tickets/csv', name: 'app_utilities_upload_tickets_csv')]
    public function index(Request $request): Response
    {
        $csvData = [];
        $form = $this->createForm(UploadTicketsCsvForm::class);
        $form->handleRequest($request);

        $preview = $form->get('preview');
        $action = $preview->isClicked() ? 'preview' : 'submit';

        $writtenTicketArray = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->getData()['file'];
            $sheetData = $this->getSheetData($file);

            $header = array_shift($sheetData);
            foreach($sheetData as $row) {
                $ticketArray[] = array_combine($header, $row);
            }

            $validatedTicketArray = ($this->uploadTicketsCsvLoader)($ticketArray);
            $writtenTicketArray = ($this->uploadTicketsCsvPersister)($validatedTicketArray, $form->getData()['event']);
        }

        return $this->render('utility_upload_tickets_csv/index.html.twig', [
            'form' => $form->createView(),
            'generated' => [],
            'csvData' => $csvData,
            'controller_name' => 'UploadTicketsCsvController',
            'writtenTicketArray' => $writtenTicketArray
        ]);
    }

    private function getSheetData(UploadedFile $uploadedFile): array
    {
        $spreadsheet = IOFactory::load($uploadedFile->getRealPath());
        return $spreadsheet->getActiveSheet()->toArray(null, true, false);
    }
}