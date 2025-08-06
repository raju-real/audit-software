<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class XlPreview extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['html' => '<p class="text-danger">No file uploaded.</p>']);
        }

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getRealPath());

            $writer = IOFactory::createWriter($spreadsheet, 'Html');
            ob_start();
            $writer->save('php://output');
            $html = ob_get_clean();

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            return response()->json(['html' => '<p class="text-danger">Error parsing Excel file.</p>']);
        }
    }
}
