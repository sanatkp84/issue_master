<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\EditedReport;
use App\Models\Report;
use App\Models\Category;
use App\Models\Activity;
use DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
  use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;
use App\Mail\UpdateMail;

class ReportController extends Controller
{
    public function ReportView(){

      $reports =  Report::where('incident_deleted',0)->paginate(20);
      
        $del_reports =  Report::where('incident_deleted',1)->paginate(20);
        

     return view('Admin.reports' , compact('reports', 'del_reports'));
    }

// Search Function


    public function search(Request $request)
    {
        $query = $request->input('query');


        if ($query) {
            // Perform search and return the search_results view
            $searchResults = Report::where('incident_name', 'LIKE', '%' . $query . '%')
                                    ->orWhere('status', 'LIKE', '%' . $query . '%')
                                    ->get();

            return view('Admin.reports', compact('searchResults'));
        }
        
    }




    public function ReportCreate(){
            $categories = Category::all();
        return view('Admin.create_report' , compact('categories'));
    }
    
    
    
    

    public function ReportSubmit(Request $request){
        

        
             $user=Auth::user();
        $involved_parties=json_encode($request->involved_parties , true);
       
         if($request->id){
            
          $report=Report::find($request->id);
              
  
              
         if($report)
            {
                
                
            //save the edited record
            $previous_report=json_encode($report ,true);
            $record_report= new EditedReport();
            $record_report->report_id= $request->id;
          $record_report->user_id  = auth::user()->id;
            $record_report->detail= $previous_report;
            $record_report->save();
            

                
                $report->incident_name=$request->name;
                $report->incident_date=$request->date;
                $report->incident_time=$request->time;
                $report->incident_location= $request->location;
                $report->members_involved=$involved_parties;
                $report->description=$request->description;
                $report->incident_category=$request->incident_category;  
                $report->incident_creartoid= auth::user()->id;
    if ($request->hasfile('attachment'))
{
  $file = $request->file('attachment');

$extenstion = $file->getClientOriginalExtension();

$filename= time(). "." .$extenstion;

$destinationPath = public_path('/uploads/');
$file->move($destinationPath, $filename);

$report->attachment = $filename ;

}
$report->update();

 $this->ActivityFunction(auth::user()->id, "User Update the Report Information ");

        
  try {
            $data = ['name' => $user->firstname, 'email' => $user->email];

            Mail::to($data['email'])->send(new MyMail($data));
            return redirect('/reports');

        } catch (\Exception $e) {
          return redirect('/reports');
        }
            }
            
         }else{

            $report= new Report();
            $report->incident_name=$request->name;
            $report->incident_date=$request->date;
            $report->incident_time=$request->time;
            $report->incident_location= $request->location;
            $report->members_involved=$involved_parties;
            $report->incident_nature=$request->incident_nature;;
            $report->description=$request->description;
            $report->incident_category=$request->incident_category;
            $report->incident_creartoid= auth::user()->id;

///  To saVe tHe imAge iN DataBasE

if ($request->hasfile('attachment'))
{
$file = $request->file('attachment');

$extenstion = $file->getClientOriginalExtension();

$filename= time(). "." .$extenstion;

$destinationPath = public_path('/uploads/');
$file->move($destinationPath, $filename);

$report->attachment = $filename ;

}
   $report->save();
            
$this->ActivityFunction(auth::user()->id, "User Created a new report");
             
             
             try {
            $data = ['name' => $user->firstname, 'email' => $user->email];

            Mail::to($data['email'])->send(new MyMail($data));
            return redirect('/reports');

        } catch (\Exception $e) {
          return redirect('/reports');
        }
           

         }

               
        
    }






    public function ReportEdit($id){
        try {
            $report = Report::findOrFail($id); // Find the report by its ID
             $categories = Category::all();
             $this->ActivityFunction(auth::user()->id, "User Edit the Report Information ");
              return view('Admin.create_report',['report'=>$report , 'categories'=>$categories]);

        } catch (\Exception $e) {
            // Handle exceptions, e.g., report or log the error
          return redirect('reports');
        }


    }


    
    public function ReportDelete($id){
        try {
            $report = Report::findOrFail($id); // Find the report by its ID

            $report->incident_deleted=1; 
             $report->update();
     $this->ActivityFunction(auth::user()->id, "User Delete the Report Record ");
            return response()->json(['message' => 'Report deleted successfully']);
        } catch (\Exception $e) {
            // Handle exceptions, e.g., report or log the error
            return response()->json(['error' => 'Failed to delete report'], 500);
        }
    }



    public function ReportDeletePermanent($id){
        try {
            
            
           
            $report = Report::destroy($id); // Find the report by its ID
          $this->ActivityFunction(auth::user()->id, "User Delete the  $id Report Permanently ");
            return response()->json(['message' => 'Report deleted successfully']);
    
        } catch (\Exception $e) {
            // Handle exceptions, e.g., report or log the error
            return response()->json(['error' => 'Failed to delete report'], 500);
        }
    }
    
    
    
    
    
    
    
    
    
   public function ReportDeleteUndo($id){
        try {
            $report = Report::findOrFail($id); // Find the report by its ID

            $report->incident_deleted=0; 
             $report->update();
            $this->ActivityFunction(auth::user()->id, "User Undo Delete Action of Report  $id ");
            
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle exceptions, e.g., report or log the error
            return response()->json(['error' => 'Failed to delete report'], 500);
        }
    }
    
    
    
    
    
    

public function calender(Request $request)
  {
      $month = $request->input('month', now()->format('m'));
      $year = $request->input('year', now()->format('Y'));
  
      $firstDayOfMonth = Carbon::create($year, $month, 1);
  
      $daysInMonth = $firstDayOfMonth->daysInMonth;
  
      // Fetch reports for the current month
      $reports = Report::whereYear('created_at', $year)
          ->whereMonth('created_at', $month)
          ->get();
  
      // Organize reports by day
      $reportByDay = [];
      foreach ($reports as $report) {
          $day = $report->created_at->day;
          $reportByDay[$day][] = $report->incident_name;
      }
  
      // Highlight today's date
      $today = now()->format('j');
  
      return view('Admin.calender', compact('month', 'firstDayOfMonth', 'year', 'daysInMonth', 'reportByDay', 'today'));
  }
public function mail(){
 

$data = ['name' => 'John Doe', 'email' => 'qamargg844@gmail.com'];

Mail::to($data['email'])->send(new MyMail($data));

}


 public function ActivityFunction($id , $activityText)
    {
        // dd($activity);
         $activity  = new Activity();
        
          $activity->user_id= $id;
          $activity->activity= $activityText;
         $activity->save();
        
        }
        


}
