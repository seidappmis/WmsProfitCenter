<?php

namespace App\Http\Controllers\Web;

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportConceptComingActualLoadingController extends Controller
{
  public function index(Request $request)
  {
    return view('web.report.report-concept-coming-vs-actual-loading.index');
  }

  public function getGraph(Request $request)
  {
    $databary = [12, 15];

    // new Graph\Graph with a drop shadow
    $__width  = 1200;
    $__height = 800;
    $graph    = new Graph\Graph($__width, $__height);
    $graph->SetShadow();

    // Use a "text" X-scale
    $graph->SetScale('textlin');
    $graph->title->SetFont(FF_ARIAL, FS_BOLD, 20);

    // Set title and subtitle
    $graph->title->Set('CONCEPT COMING VS ACTUAL LOADING - ' . $request->input('area'));

    // Use built in font
    $graph->title->SetFont(FF_FONT1, FS_BOLD);

    // Create the bar plot
    $b1 = new Plot\BarPlot($databary);
    $b1->SetLegend('Temperature');
    // $b1->SetAbsWidth(6);
    //$b1->SetShadow();

    // The order the plots are added determines who's ontop
    $graph->Add($b1);

    // Finally output the  image
    $graph->Stroke();
  }
}
