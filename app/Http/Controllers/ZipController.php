<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use ZipArchive;
use App\assignment;
use App\submission;

class ZipController extends Controller
{
    //
    public function allAssignDownload($id){
        $assignmentID = $id;
        $zip = new ZipArchive;

        $fileName = $assignmentID.'_submission.zip';

        $assignment = assignment::find($assignmentID);
        $pathString = '../storage/app/';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE){

            $submissions = submission::leftJoin('users', 'submission.studID', '=', 'users.id')->where('assignmentID', $id)->get();
            foreach($submissions as $submission){
                $newPath = $pathString.$submission->submitFilePath;

                $info = pathinfo($newPath);
                $extension = $info['extension'];

                $fileInZipName = $submission->idCode."_".$submission->assignmentID.'.'.$extension;
                $zip->addFile($newPath, $fileInZipName);
            }
            $zip->close();

        }
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }
}
